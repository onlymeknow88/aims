<?php

namespace Modules\DocumentSystem\Services;

use App\Exports\JsaDocumentExport;
use App\Exports\PtwDocumentExport;
use App\Jobs\NotifyCreateJsaDocument;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\JsaDocumentActivity;
use Modules\DocumentSystem\Entities\JsaDocumentAttachment;
use Modules\DocumentSystem\Entities\JsaDocumentPeople;
use Modules\DocumentSystem\Entities\PtwDocument;
use Modules\DocumentSystem\Entities\PtwDocumentActivity;
use Modules\DocumentSystem\Entities\PtwDocumentAttachment;
use Modules\DocumentSystem\Entities\PtwDocumentPeople;
use App\Models\User;
use App\Notifications\NewJsaDocumentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PtwService
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
            $img_preview = asset('storage/tmp/ptw/' . $name);
        }
        $ext_path = $this->define_file_icon($ext);
        $save = Storage::disk('public')->putFileAs('tmp/ptw', $file, $name);

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
     * Function to update document
     * @param array data
     */
    public function update($data, $id): void
    {
        $peoples = $data['peoples'];
        $documents = $data['documents'];
        $is_notify = $data['is_notify_email'];

        $document = PtwDocument::find($id);
        $current_status = $document->status;

        // delete and insert peoples
        for ($y = 0; $y < count($peoples); $y++) {
            $people_to_be_delete = PtwDocumentPeople::select('id', 'email')
                ->where('document_id', $id)
                ->where('email', '!=', $peoples[$y])
                ->get();
            if (count($people_to_be_delete) > 0) {
                for ($b = 0; $b < count($people_to_be_delete); $b++) {
                    PtwDocumentPeople::where('id', $people_to_be_delete[$b]->id)
                        ->delete();
                }
            }
        }
        for ($a = 0; $a < count($peoples); $a++) {

            $user = User::select('email', 'id')
                ->where('email', $peoples[$a])
                ->first();
            $type = PtwDocumentPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = PtwDocumentPeople::USER_INSIDE_OFFICE;
            }

            $people = PtwDocumentPeople::where('document_id', $id)
                ->where('email', $peoples[$a])
                ->first();
            if (!$people) {
                $people = new PtwDocumentPeople();
            }
            $people->is_notify_email = $is_notify;
            $people->email = $peoples[$a];
            $people->type = $type;
            $people->document_id = $id;
            $people->user_id = $user ? $user->id : null;
            $people->save();
        }

        $document->title = $data['title'];
        $document->department_id = $data['department_id'];
        $document->status = $data['status'];
        $document->doc_created = $data['doc_created'];
        $document->inactive_at = $data['inactive_at'];
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
                $current_media = PtwDocumentAttachment::find($id_media);
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
        $this->update_activity([
            'status' => $data['status'],
            'id' => $id,
        ]);
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
        $document = PtwDocument::create($data);

        // search email in database and insert to related table
        for ($a = 0; $a < count($peoples); $a++) {
            $user = User::select('email', 'id')
                ->where('id', $peoples[$a])
                ->first();
            $type = PtwDocumentPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = PtwDocumentPeople::USER_INSIDE_OFFICE;
            }

            $model = new PtwDocumentPeople();
            $model->user_id = $peoples[$a];
            $model->document_id = $document->id;
            $model->type = $type;
            $model->email = $user ? $user->email : null;
            $model->is_notify_email = $data['is_notify_email'];
            $model->save();
        }

        // handle document
        $this->handle_upload_document($documents, $document->id);

        // update activity
        $this->update_activity([
            'status' => $data['status'],
            'id' => $document->id,
        ]);

        // send email via laravel job if status is submit for review
        if ($data['is_notify_email']) {
            //            NotifyCreateJsaDocument::dispatch($document->id);
        }
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
            if (File::exists(public_path('storage/tmp/ptw/' . $documents[$b]['name']))) {
                if (!Storage::disk('public')->exists('ptw/' . $document_id)) {
                    Storage::disk('public')->makeDirectory('ptw/' . $document_id);
                }

                // File::move(public_path('storage/tmp/ptw/' . $documents[$b]['name']), public_path('storage/ptw/' . $document_id . '/' . $documents[$b]['name']));

                Storage::disk('public')->move('tmp/ptw/' . $documents[$b]['name'], 'ptw/' . $document_id . '/' . $documents[$b]['name']);

                $model_document = new PtwDocumentAttachment();
                $model_document->document_id = $document_id;
                $model_document->file_name = $documents[$b]['name'];
                $model_document->file_size = $documents[$b]['size'];
                $model_document->file_type = $documents[$b]['ext'];
                $model_document->path = public_path('storage/ptw/' . $document_id . '/' . $documents[$b]['name']);
                $model_document->save();

                // File::delete(public_path('storage/tmp/ptw/' . $documents[$b]['name']));
                Storage::disk('public')->delete('tmp/ptw/' . $documents[$b]['name']);
            }
        }

        return true;
    }

    /**
     * Function to get document Detail
     */
    public function detail($id): array
    {
        $detail = PtwDocument::with([
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
     * Function to update activity
     * @param $data
     * @return void
     */
    public function update_activity($data): void
    {
        $model = new PtwDocumentActivity();
        if ($data['status'] == PtwDocument::ACTIVE) {
            $model->description = trans('global.document_active');
        } else if ($data['status'] == PtwDocument::INACTIVE) {
            $model->description = trans('global.document_inactive');
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
            'title', 'user_id', 'doc_created',
        ];
        for ($a = 0; $a < count($ids); $a++) {
            $document = PtwDocument::select($select)
                ->with('user:id,name')
                ->orderBy('id', 'asc')
                ->find($ids[$a]);
            $documents[] = [
                'id' => $document->id,
                'title' => $document->title,
                'document_number' => $document->document_number,
                'pic' => $document->user->name,
                'status' => $document->status == PtwDocument::ACTIVE ? 'Active' : 'Inactive',
                'first_doc_created' => date('m/d/Y', strtotime($document->doc_created)),
            ];
        }

        if (count($history) > 0) {
            for ($b = 0; $b < count($history); $b++) {
                $new[] = count($history[$b]);
            }
            $max = max($new);
        }
        return Excel::download(new PtwDocumentExport($documents, $max ?? 0), 'Dokumen PTW - ' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Function to change status PTW Document
     * @param $data
     * @return bool
     */
    public function changeStatus($data): bool
    {
        $doc = PtwDocument::find($data['id']);
        $doc->status = $data['status'];
        $doc->doc_created = $data['status'] == PtwDocument::ACTIVE ? $data['doc_created'] : $doc->doc_created;
        $doc->inactive_at = $data['status'] == PtwDocument::INACTIVE ? date('Y-m-d H:i:s') : null;
        $doc->save();

        // update activity
        $this->update_activity([
            'status' => $data['status'],
            'id' => $data['id'],
        ]);

        return true;
    }
}
