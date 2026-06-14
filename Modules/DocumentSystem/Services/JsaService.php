<?php

namespace Modules\DocumentSystem\Services;

use App\Exports\JsaDocumentExport;
use App\Jobs\NotifyCreateDocument;
use App\Jobs\NotifyCreateJsaDocument;
use Modules\DocumentSystem\Entities\Activity;
use Modules\DocumentSystem\Entities\ActivityAttachment;
use Modules\DocumentSystem\Entities\Attachment;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\InvitedPeople;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\JsaDocumentActivity;
use Modules\DocumentSystem\Entities\JsaDocumentAttachment;
use Modules\DocumentSystem\Entities\JsaDocumentPeople;
use App\Models\User;
use App\Notifications\NewJsaDocumentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class JsaService
{
    /**
     * Function to handle temporary file upload
     */
    public function temporary_upload(Request $request)
    {
        $file = $request->file('file');
        $size = $file->getSize();
        $fix_size = round($size / 1024 / 1024, 4);

        // save file to tmp
        // $name = date('Y-m-d-H:i') . '-' . $file->getClientOriginalName(); // Linux/CentOS format (contains illegal ':' for Windows)
        $name = date('Y-m-d-Hi') . '-' . $file->getClientOriginalName(); // Windows compatible format
        $ext = $file->getClientOriginalExtension();
        $ext_path = asset('images/icons/pdf.png');
        $img_preview = null;
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
            $img_preview = asset('storage/tmp/jsa/' . $name);
        }
        $ext_path = $this->define_file_icon($ext);
        $save = Storage::disk('public')->putFileAs('tmp/jsa', $file, $name);

        $is_error = true;
        if ($save) {
            $data = [
                'name' => $name,
                'ext' => $ext,
                'ext_icon' => $ext_path,
                'size' => $fix_size,
                'img_preview' => $img_preview,
            ];

            $is_error = false;
        }

        return [
            'data' => $data ?? [],
            'error' => $is_error
        ];
    }

    /**
     * Function to define ext icon
     * @param string ext
     */
    public function define_file_icon($ext)
    {
        $ext_path = asset('images/icons/pdf.png');
        if ($ext == 'xlsx' || $ext == 'xlx') {
            $ext_path = asset('images/icons/excel.png');
        } else if ($ext == 'pdf') {
            $ext_path = asset('images/icons/pdf.png');
        } else if ($ext == 'docx' || $ext == 'doc') {
            $ext_path = asset('images/icons/word.png');
        } else if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
            $ext_path = asset('images/icons/jpgicon.png');
        }

        return $ext_path;
    }

    /**
     * Function to store new document active
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $peoples = $data['peoples'];
        $documents = $data['documents'];

        // unset some values
        unset($data['peoples']);
        unset($data['documents']);

        // insert document
        $document = JsaDocument::create($data);

        // search email in database and insert to related table
        for ($a = 0; $a < count($peoples); $a++) {
            $user = User::select('email', 'id')
                ->where('id', $peoples[$a])
                ->first();
            $type = JsaDocumentPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = JsaDocumentPeople::USER_INSIDE_OFFICE;
            }

            $model = new JsaDocumentPeople();
            $model->user_id = $peoples[$a];
            $model->document_id = $document->id;
            $model->type = $type;
            $model->email = $user ? $user->email : null;
            $model->is_notify_email = $data['is_notify_email'];
            $model->save();
        }

        // handle document
        $this->handle_upload_document($documents, $document->id);

        // send email via laravel job if status is submit for review
        if ($data['is_notify_email']) {
            NotifyCreateJsaDocument::dispatch($document->id);
        }
    }

    /**
     * Function to update document
     * @param array data
     */
    public function update($data, $id): void
    {
        $peoples = $data['peoples'];
        $documents = $data['documents'];
        $is_notify = $data['is_notify_email'];
        // dd($data);
        $document = JsaDocument::find($id);
        $current_status = $document->status;

        // delete and insert peoples
        for ($y = 0; $y < count($peoples); $y++) {
            $people_to_be_delete = JsaDocumentPeople::select('id', 'email')
                ->where('document_id', $id)
                ->where('id', '!=', $peoples[$y])
                ->get();
            if (count($people_to_be_delete) > 0) {
                for ($b = 0; $b < count($people_to_be_delete); $b++) {
                    JsaDocumentPeople::where('id', $people_to_be_delete[$b]->id)
                        ->delete();
                }
            }
        }
        for ($a = 0; $a < count($peoples); $a++) {

            $user = User::select('email', 'id')
                ->where('id', $peoples[$a])
                ->first();
            $type = JsaDocumentPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = JsaDocumentPeople::USER_INSIDE_OFFICE;
            }

            $people = JsaDocumentPeople::where('document_id', $id)
                ->where('id', $peoples[$a])
                ->first();
            if (!$people) {
                $people = new JsaDocumentPeople();
            }
            $people->is_notify_email = $is_notify;
            $people->email = $user ? $user->email : null;
            $people->type = $type;
            $people->document_id = $id;
            $people->user_id = $peoples[$a];
            $people->save();
        }

        $document->title = $data['title'];
        $document->department_id = $data['department_id'];
        $document->department_code_id = $data['department_code_id'];
        $document->user_id = $data['user_id'];
        $document->status = $data['status'];
        $document->description = $data['description'];
        $document->document_number = $data['document_number'] ?? null;
        $document->detail_location = $data['detail_location'];
        $document->save();

        /**
         ** Delete current files if CURRENT DOCUMENT STATUS is NOT 6 / PREPARE_ROOTING_REVIEW
         ** the goal is to keep the old files as documentation
         */
        // if ($current_status == Document::PREPARE_ROOTING_REVIEW) {
        //     $this->handle_document_rooting_approval($documents, $id, false);
        // } else {
        // }
        if (count($data['deleted_id_media']) > 0) {
            for ($x = 0; $x < count($data['deleted_id_media']); $x++) {
                $id_media = $data['deleted_id_media'][$x];
                $current_media = JsaDocumentAttachment::find($id_media);
                if ($current_media) {
                    if (File::exists($current_media->path)) {
                        File::delete($current_media->path);
                    }
                    $current_media->delete();
                }
            }
        }

        $this->handle_upload_document($documents, $document->id);

        // update activity
        if ($data['status'] != JsaDocument::DRAFT) {
            $this->update_activity([
                'status' => $data['status'],
                'id' => $id,
            ]);
        }
    }

    /**
     * Function to get document Detail
     */
    public function detail($id): array
    {
        $detail = JsaDocument::with([
            'attachments' => function ($query) {
                $query->where('status', 1);
            },
            'user', 'peoples',
            'department:id,name,company_id',
            'department.company:id,company_name,address',
            'createdby:id,name',
            'activities' => function ($query) {
                $query->select('id', 'document_id', 'user_id', 'description', 'created_at')
                    ->orderBy('created_at', 'desc');
            },
            'activities.user:id,name,department_id',
            'activities.user.department:id,name'
        ])->find($id);
        $attachments = $detail->attachments;
        $activities = $detail->activities;

        return [
            'detail' => $detail,
            'attachments' => $attachments,
            'activities' => $activities,
        ];
    }

    /**
     * Function to renew Document
     * Old document will remove to obsolate
     * And create a new one then save to Draft
     * @param $data
     * @return boolean
     */
    public function renew_document($data): bool
    {
        $id = $data['id'];
        $documents = $data['tmp'];
        $current_document = JsaDocument::find($id);

        $current_history = $current_document->history_revision;
        if (!$current_history) {
            $history = [$current_document->doc_created];
        } else {
            $history = array_merge(json_decode($current_history, true), [$current_document->doc_created]);
        }
        $current_revision = $current_document->revision ?? 0;

        // replicate and save to draft
        $new_document = $current_document->replicate();
        $new_document->status = JsaDocument::DRAFT;
        $new_document->history_revision = json_encode($history);
        $new_document->revision = (int) $current_revision + 1;
        $new_document->detail_location = $data['location'];
        $new_document->doc_created = date('Y-m-d H:i:s');
        $new_document->related_document_id = $current_document->id;
        $new_document->save();

        // handle document
        $this->handle_upload_document($documents, $new_document->id);

        // throw current document to obsolate
        $current_document->status = JsaDocument::OBSOLATE;
        $current_document->is_obsolate = true;
        $current_document->save();

        //update activity
        $this->update_activity([
            'status' => 'renew',
            'id' => $new_document->id,
            'revision' => $new_document->revision,
        ]);
        $this->update_activity([
            'status' => JsaDocument::OBSOLATE,
            'id' => $current_document->id,
        ]);

        return true;
    }

    public function create_new_document($document_id)
    {
        $current_document = JsaDocument::find($document_id);

        $new_document = $current_document->replicate();
        $new_document->status = JsaDocument::DRAFT;
        $new_document->revision = 0;
        $new_document->history_revision = null;
        $new_document->related_document_id = null;
        $new_document->doc_created = date('Y-m-d H:i:s');
        $new_document->save();
    }

    /**
     * Function to handle Document Upload
     * @param $documents
     * @param $document_id
     * @return true
     */
    public function handle_upload_document($documents, $document_id): bool
    {
        for ($b = 0; $b < count($documents); $b++) {
            if (File::exists(public_path('storage/tmp/jsa/' . $documents[$b]['name']))) {
                if (!Storage::disk('public')->exists('jsa/' . $document_id)) {
                    Storage::disk('public')->makeDirectory('jsa/' . $document_id);
                }

                // File::move(public_path('storage/tmp/jsa/' . $documents[$b]['name']), public_path('storage/jsa/' . $document_id . '/' . $documents[$b]['name']));

                Storage::disk('public')->move('tmp/jsa/' . $documents[$b]['name'], 'jsa/' . $document_id . '/' . $documents[$b]['name']);

                $model_document = new JsaDocumentAttachment();
                $model_document->document_id = $document_id;
                $model_document->file_name = $documents[$b]['name'];
                $model_document->file_size = $documents[$b]['size'];
                $model_document->file_type = $documents[$b]['ext'];
                $model_document->path = public_path('storage/jsa/' . $document_id . '/' . $documents[$b]['name']);
                $model_document->save();

                // File::delete(public_path('storage/tmp/jsa/' . $documents[$b]['name']));
                Storage::disk('public')->delete('tmp/jsa/' . $documents[$b]['name']);
            }
        }

        return true;
    }

    /**
     * Function to update activity
     * @param $data
     * @return void
     */
    public function update_activity($data): void
    {
        $model = new JsaDocumentActivity();
        if ($data['status'] == JsaDocument::ACTIVE) {
            $model->description = 'Document is Active';
        } else if ($data['status'] == 'renew') {
            $model->description = 'Document Renew and has a revision status of ' . $data['revision'] . ' times';
        } else if ($data['status'] == JsaDocument::OBSOLATE) {
            $model->description = 'Document now moved to Obsolate';
        }
        $model->document_id = $data['id'];
        $model->user_id = auth()->id();
        $model->save();
    }

    /**
     * Function to export JSA Document
     * @param $itemSelected
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($itemSelected, $type)
    {
        $ids = array_values($itemSelected);
        $documents = [];
        $history = [];
        $select = [
            'id', 'document_number', 'department_id',
            'title', 'user_id', 'revision',
            'doc_created', 'related_document_id',
            'history_revision',
        ];
        for ($a = 0; $a < count($ids); $a++) {
            $document = JsaDocument::select($select)
                ->with('user:id,name')
                ->orderBy('id', 'asc')
                ->find($ids[$a]);
            if ($document->history_revision) {
                $history[] = json_decode($document->history_revision, TRUE);
            }
            $documents[] = [
                'id' => $document->id,
                'title' => $document->title,
                'document_number' => $document->document_number,
                'pic' => $document->user->name,
                'revision' => $document->revision ?? 0,
                'first_doc_created' => date('m/d/Y', strtotime($document->doc_created)),
                'revision_date' => $document->fix_history_revision,
            ];
        }

        if (count($history) > 0) {
            for ($b = 0; $b < count($history); $b++) {
                $new[] = count($history[$b]);
            }
            $max = max($new);
        }
        if ($type == 'active') {
            $t = 'Aktif';
        } else if ($type == 'obsolate') {
            $t = 'Obsolate';
        } else if ($type == 'draft') {
            $t = 'Draft';
        }
        return Excel::download(new JsaDocumentExport($documents, $max ?? 0), 'Dokumen ' . $t . ' JSA - ' . date('Y-m-d') . '.xlsx');
    }
}
