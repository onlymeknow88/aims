<?php

namespace Modules\DocumentSystem\Services;

use App\Jobs\NotifyCreateDocument;
use App\Models\Company;
use Modules\DocumentSystem\Entities\Activity;
use Modules\DocumentSystem\Entities\ActivityAttachment;
use Modules\DocumentSystem\Entities\Attachment;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\InvitedPeople;
use Modules\DocumentSystem\Entities\Mapping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Testing\Browser\Pages\Attach;
use setasign\Fpdi\Fpdi;

class DocumentSystemService
{
    /**
     * Function to get document Detail
     */
    public function detail($id)
    {
        $detail = Document::with([
            'attachments' => function ($query) {
                $query->where('status', 1);
            },
            'user', 'peoples',
            'mapping:id,name,category_id',
            'mapping.category:id,name,module_id',
            'mapping.category.module:id,name',
            'department:id,name,company_id',
            'department.company:id,company_name,address',
            'createdby:id,name',
            'activities' => function ($query) {
                $query->select('id', 'document_id', 'user_id', 'description', 'created_at')
                    ->orderBy('created_at', 'desc');
            },
            'activities.user:id,name,department_id',
            'activities.user.department:id,name',
            'activities.attachments',
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
     * Function to store new document active
     */
    public function store($data)
    {
        $peoples = $data['peoples'];
        $documents = $data['documents'];

        // unset some values
        unset($data['peoples']);
        unset($data['documents']);

        // insert document
        $document = Document::create($data);

        // search email in database and insert to related table
        for ($a = 0; $a < count($peoples); $a++) {
            $user = User::select('email', 'id')
                ->where('id', $peoples[$a])
                ->first();
            $type = InvitedPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = InvitedPeople::USER_INSIDE_OFFICE;
            }

            $model = new InvitedPeople();
            $model->user_id = $peoples[$a];
            $model->document_id = $document->id;
            $model->user_type = $type;
            $model->email = $user ? $user->email : null;
            $model->is_notify_email = $data['is_notify_email'];
            $model->save();
        }

        // handle document
        for ($b = 0; $b < count($documents); $b++) {
            if (File::exists(public_path('storage/tmp/document_systems/' . $documents[$b]['name']))) {
                if (!Storage::disk('public')->exists('document_systems/' . $document->id)) {
                    Storage::disk('public')->makeDirectory('document_systems/' . $document->id);
                }

                Storage::disk('public')->move('tmp/document_systems/' . $documents[$b]['name'], 'document_systems/' . $document->id . '/' . $documents[$b]['name']);

                $model_document = new Attachment();
                $model_document->document_id = $document->id;
                $model_document->file_name = $documents[$b]['name'];
                $model_document->file_size = $documents[$b]['size'];
                $model_document->file_type = $documents[$b]['ext'];
                $model_document->path = public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']);
                $model_document->save();

                Storage::disk('public')->delete('tmp/document_systems/' . $documents[$b]['name']);
            }
        }

        // send email via laravel job if status is submit for review
        if (
            $data['status'] == Document::WAITNG_REVIEW &&
            $data['is_notify_email']
        ) {
            NotifyCreateDocument::dispatch($document->id);
        }
    }

    /**
     * Function to update document
     * @param array data
     */
    public function update($data, $id)
    {
        $peoples = $data['peoples'];
        $documents = $data['documents'];
        $is_notify = $data['is_notify_email'];
        // dd($data);
        $document = Document::find($id);
        $current_status = $document->status;

        // delete and insert peoples
        for ($y = 0; $y < count($peoples); $y++) {
            $people_to_be_delete = InvitedPeople::select('id', 'email')
                ->where('document_id', $id)
                ->where('id', '!=', $peoples[$y])
                ->get();
            if (count($people_to_be_delete) > 0) {
                for ($b = 0; $b < count($people_to_be_delete); $b++) {
                    InvitedPeople::where('id', $people_to_be_delete[$b]->id)
                        ->delete();
                }
            }
        }
        for ($a = 0; $a < count($peoples); $a++) {

            $user = User::select('email', 'id')
                ->where('id', $peoples[$a])
                ->first();
            $type = InvitedPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = InvitedPeople::USER_INSIDE_OFFICE;
            }

            $people = InvitedPeople::where('document_id', $id)
                ->where('id', $peoples[$a])
                ->first();
            if (!$people) {
                $people = new InvitedPeople();
            }
            $people->is_notify_email = $is_notify;
            $people->email = $user ? $user->email : null;
            $people->document_id = $document->id;
            $people->user_type = $type;
            $people->user_id = $peoples[$a];
            $people->save();
        }

        $document->title = $data['title'];
        $document->department_id = $data['department_id'];
        $document->department_code_id = $data['department_code_id'];
        $document->mapping_id = $data['mapping_id'];
        $document->user_id = $data['user_id'];
        $document->upload_type = $data['upload_type'];
        $document->document_level = $data['document_type'];
        $document->prefix_code = $data['prefix_code'] ?? null;
        $document->status = $data['status'];
        $document->description = $data['description'];
        $document->sop_number = $data['sop_number'] ?? null;
        $document->sop_add_win = $data['sop_add_win'] ?? null;
        $document->sop_add_form = $data['sop_add_form'] ?? null;
        $document->document_number = $data['document_number'] ?? null;
        $document->save();

        // handle document

        /**
         ** Delete current files if CURRENT DOCUMENT STATUS is NOT 6 / PREPARE_ROOTING_REVIEW
         ** the goal is to keep the old files as documentation
         */
        if ($current_status == Document::PREPARE_ROOTING_REVIEW) {
            $this->handle_document_rooting_approval($documents, $id, true);
        } else {
            if (count($data['deleted_id_media']) > 0) {
                for ($x = 0; $x < count($data['deleted_id_media']); $x++) {
                    $id_media = $data['deleted_id_media'][$x];
                    $current_media = Attachment::find($id_media);
                    if ($current_media) {
                        if (File::exists($current_media->path)) {
                            File::delete($current_media->path);
                        }
                        $current_media->delete();
                    }
                }
            }

            for ($b = 0; $b < count($documents); $b++) {
                if (File::exists(public_path('storage/tmp/document_systems/' . $documents[$b]['name']))) {
                    if (!Storage::disk('public')->exists('document_systems/' . $document->id)) {
                        Storage::disk('public')->makeDirectory('document_systems/' . $document->id);
                    }

                    // File::move(public_path('storage/tmp/document_systems/' . $documents[$b]['name']), public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']));

                    Storage::disk('public')->move('tmp/document_systems/' . $documents[$b]['name'], 'document_systems/' . $document->id . '/' . $documents[$b]['name']);

                    $model_document = new Attachment();
                    $model_document->document_id = $document->id;
                    $model_document->file_name = $documents[$b]['name'];
                    $model_document->file_size = $documents[$b]['size'];
                    $model_document->file_type = $documents[$b]['ext'];
                    $model_document->path = public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']);
                    $model_document->save();

                    Storage::disk('public')->delete('tmp/document_systems/' . $documents[$b]['name']);
                }
            }
        }

        // update activity
        if ($data['status'] != Document::DRAFT) {
            $this->update_activity([
                'status' => $data['status'],
                'id' => $id,
            ]);

            // send email via laravel job if status is submit for review
            if (
                $data['status'] == Document::WAITNG_REVIEW &&
                $data['is_notify_email']
            ) {
                NotifyCreateDocument::dispatch($document->id);
            }
        }
    }

    /**
     * Function to handle document upload when maker submit for rooting approval
     */
    /*
    public function handle_document_rooting_approval($files, $id, $add_watermark)
    {
        // Normalize files array to ensure consistent keys (supporting both database columns and request inputs)
        $normalizedFiles = [];
        foreach ($files as $fileItem) {
            $normalizedFiles[] = [
                'id' => $fileItem['id'] ?? null,
                'file_name' => $fileItem['file_name'] ?? $fileItem['name'] ?? null,
                'file_size' => $fileItem['file_size'] ?? $fileItem['size'] ?? 0,
                'file_type' => $fileItem['file_type'] ?? $fileItem['ext'] ?? null,
            ];
        }
        $files = $normalizedFiles;

        // update status current attachment to inactive
        Attachment::where('document_id', $id)
            ->update(['status' => false]);

        // add watermark to file request and move to desire folder
        for ($a = 0; $a < count($files); $a++) {
            if (isset($files[$a]['id'])) {
                $file = public_path('storage/document_systems/' . $id . '/' . $files[$a]['file_name']);
            } else {
                $file = public_path('storage/tmp/document_systems/' . $files[$a]['file_name']);
            }
            $text_image  = public_path('images/watermark.png');

            if ($add_watermark) {
                if (strpos($files[$a]['file_name'], 'Final-') === 0) {
                    $final_filename = $files[$a]['file_name'];
                } else {
                    $final_filename = 'Final-' . $files[$a]['file_name'];
                }
            } else {
                $final_filename = $files[$a]['file_name'];
            }
            $output_file = storage_path('app/public/' . 'document_systems/' . $id . '/' . $final_filename);

            // Ensure destination directory exists
            $destination_dir = dirname($output_file);
            if (!File::exists($destination_dir)) {
                File::makeDirectory($destination_dir, 0755, true);
            }

            $watermark_success = false;
            $already_watermarked = ($add_watermark && strpos($files[$a]['file_name'], 'Final-') === 0);

            if ($already_watermarked) {
                if (File::exists($file)) {
                    if ($file !== $output_file) {
                        File::copy($file, $output_file);
                    }
                    $watermark_success = true;
                }
            } else {
                if (File::exists($file)) {
                    try {
                        $pdf = new Fpdi();
                        $pagecount = $pdf->setSourceFile($file);

                        // Add watermark image to PDF pages
                        for ($i = 1; $i <= $pagecount; $i++) {
                            $tpl = $pdf->importPage($i);
                            $size = $pdf->getTemplateSize($tpl);
                            $pdf->addPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                            $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

                            //Put the watermark
                            $xxx_final = ($size['width'] - 160);
                            $yyy_final = ($size['height'] - 225);
                            if ($add_watermark) {
                                $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png');
                            }
                        }
                        $pdf->Output('F', $output_file);
                        $watermark_success = true;
                    } catch (\Throwable $e) {
                        \Log::warning("Watermarking failed for file {$files[$a]['file_name']} in document ID {$id}. Falling back to copying original file. Error: " . $e->getMessage());
                    }
                }
            }

            if (!$watermark_success) {
                // Fallback: copy the original file directly to output file destination without watermark
                if (File::exists($file)) {
                    File::copy($file, $output_file);
                } else {
                    return $files[$a]['file_name'] . ' file not exist';
                }
            }

            $model_document = new Attachment();
            $model_document->document_id = $id;
            $model_document->file_name = $final_filename;
            $model_document->file_size = $files[$a]['file_size'];
            $model_document->file_type = $files[$a]['file_type'];
            $model_document->path = public_path('storage/document_systems/' . $id . '/' . $final_filename);
            $model_document->status = true;
            $model_document->save();
        }
    }
    */

    public function handle_document_rooting_approval($files, $id, $add_watermark)
    {
        // Normalize files array to ensure consistent keys (supporting both database columns and request inputs)
        $normalizedFiles = [];
        foreach ($files as $fileItem) {
            $normalizedFiles[] = [
                'id' => $fileItem['id'] ?? null,
                'file_name' => $fileItem['file_name'] ?? $fileItem['name'] ?? null,
                'file_size' => $fileItem['file_size'] ?? $fileItem['size'] ?? 0,
                'file_type' => $fileItem['file_type'] ?? $fileItem['ext'] ?? null,
            ];
        }
        $files = $normalizedFiles;

        // update status current attachment to inactive
        Attachment::where('document_id', $id)
            ->update(['status' => false]);

        $document = Document::find($id);

        // add watermark to file request and move to desire folder
        for ($a = 0; $a < count($files); $a++) {
            if (isset($files[$a]['id'])) {
                $file = public_path('storage/document_systems/' . $id . '/' . $files[$a]['file_name']);
            } else {
                $file = public_path('storage/tmp/document_systems/' . $files[$a]['file_name']);
            }
            $text_image  = public_path('images/watermark.png');

            if ($add_watermark) {
                if (strpos($files[$a]['file_name'], 'Final-') === 0) {
                    $final_filename = $files[$a]['file_name'];
                } else {
                    $final_filename = 'Final-' . $files[$a]['file_name'];
                }
            } else {
                $final_filename = $files[$a]['file_name'];
            }
            $output_file = storage_path('app/public/' . 'document_systems/' . $id . '/' . $final_filename);

            // Ensure destination directory exists
            $destination_dir = dirname($output_file);
            if (!File::exists($destination_dir)) {
                File::makeDirectory($destination_dir, 0755, true);
            }

            $watermark_success = false;
            $already_watermarked = ($add_watermark && strpos($files[$a]['file_name'], 'Final-') === 0);

            if ($already_watermarked) {
                if (File::exists($file)) {
                    if ($file !== $output_file) {
                        File::copy($file, $output_file);
                    }
                    $watermark_success = true;
                }
            } else {
                if (File::exists($file)) {
                    try {
                        $orientation = $this->detect_pdf_orientation($file);
                        $data = [
                            'watermark'  => $text_image,
                        ];

                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('document_system_final.final_pdf', $data)
                            ->setPaper('a4', $orientation);

                        $pdf->save($output_file);
                        $watermark_success = true;
                    } catch (\Throwable $e) {
                        \Log::warning("DomPDF generation failed for file {$files[$a]['file_name']} in document ID {$id}. Falling back to copying original file. Error: " . $e->getMessage());
                    }
                }
            }

            if (!$watermark_success) {
                // Fallback: copy the original file directly to output file destination without watermark
                if (File::exists($file)) {
                    File::copy($file, $output_file);
                } else {
                    return $files[$a]['file_name'] . ' file not exist';
                }
            }

            $model_document = new Attachment();
            $model_document->document_id = $id;
            $model_document->file_name = $final_filename;
            $model_document->file_size = $files[$a]['file_size'];
            $model_document->file_type = $files[$a]['file_type'];
            $model_document->path = public_path('storage/document_systems/' . $id . '/' . $final_filename);
            $model_document->status = true;
            $model_document->save();
        }
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
     * Function to move file from tmp folder to desire folder
     */
    public function move_file($files, $target_path)
    {
        $res = [];
        for ($a = 0; $a < count($files); $a++) {
            if (File::exists(public_path('storage/tmp/document_systems/' . $files[$a]['name']))) {
                if (!Storage::disk('public')->exists($target_path)) {
                    Storage::disk('public')->makeDirectory($target_path);
                }
                Storage::disk('public')->move('tmp/document_systems/' . $files[$a]['name'], $target_path . '/' . $files[$a]['name']);

                $res[] = [
                    'path' => asset($target_path . '/' . $files[$a]['name']),
                    'name' => $files[$a]['name'],
                    'file_size' => $files[$a]['size'],
                    'ext' => $files[$a]['ext'],
                ];

                Storage::disk('public')->delete('tmp/document_systems/' . $files[$a]['name']);
            }
        }

        return $res;
    }

    /**
     * Function to handle temporary file upload
     */
    public function temporary_upload(Request $request,)
    {
        $file = $request->file('file');
        $size = $file->getSize();
        $fix_size = round($size / 1024, 2);

        // save file to tmp
        // $name = date('Y-m-d-H:i') . '-' . $file->getClientOriginalName(); // Linux/CentOS format (contains illegal ':' for Windows)
        $name = date('Y-m-d-Hi') . '-' . $file->getClientOriginalName(); // Windows compatible format
        $ext = $file->getClientOriginalExtension();
        $ext_path = asset('images/icons/pdf.png');
        $img_preview = null;
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
            $img_preview = asset('storage/tmp/document_systems/' . $name);
        }
        $ext_path = $this->define_file_icon($ext);
        $save = Storage::disk('public')->putFileAs('tmp/document_systems', $file, $name);

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
     * Function to update document activity
     * @param array data
     * @param string id
     * @param any status
     * @param string child_folder
     * @param array files
     */
    public function update_activity($data)
    {
        $model = new Activity();
        if ($data['status'] == Document::WAITNG_REVIEW) {
            $model->description = trans('global.waiting_review');
        } else if ($data['status'] == Document::ON_REVISION) {
            $model->description = trans('global.on_revision');
        } else if ($data['status'] == Document::ROOTING_REVIEW) {
            $model->description = trans('global.on_rooting_review');
        } else if ($data['status'] == Document::PREPARE_ROOTING_REVIEW) {
            $model->description = trans('global.preparing_for_final_checking');
        } else if ($data['status'] == Document::ACTIVE) {
            $model->description = trans('global.document_active');
        }
        $model->document_id = $data['id'];
        $model->user_id = auth()->id();
        $model->save();

        if (isset($data['files'])) {
            $path = 'storage/document_systems/' . $data['id'] . '/';
            if (isset($data['child_folder'])) {
                $path = 'storage/document_systems/' . $data['id'] . '/' . $data['child_folder'] . '/';
            }
            for ($a = 0; $a < count($data['files']); $a++) {
                $model_act = new ActivityAttachment();
                $model_act->activity_id = $model->id;
                $model_act->path = asset($path . $data['files'][$a]['name']);
                $model_act->file_size = $data['files'][$a]['size'];
                $model_act->file_type = $data['files'][$a]['ext'];
                $model_act->name = $data['files'][$a]['name'];
                $model_act->save();
            }
        }
    }

    /**
     * Function to return document
     */
    public function return($data)
    {
        $document = Document::find($data['id']);
        $document->status = Document::ON_REVISION;
        $document->save();

        $activity = new Activity();
        $activity->document_id = $data['id'];
        $activity->user_id = auth()->id();
        $activity->description = $data['reason'];
        $activity->save();

        $files = $data['proofs'];
        for ($a = 0; $a < count($files); $a++) {
            $model = new ActivityAttachment();
            $model->activity_id = $activity->id;
            $model->path = asset('storage/document_systems/' . $data['id'] . '/revision/' . $files[$a]['name']);
            $model->file_size = $files[$a]['size'];
            $model->file_type = $files[$a]['ext'];
            $model->name = $files[$a]['name'];
            $model->save();
        }

        if (count($files) > 0) {
            $upload = $this->move_file($files, 'document_systems/' . $data['id'] . '/revision');
        }
    }

    /**
     * Function to submit document to next rooting approval
     */
    public function submit_rooting_approval($id)
    {
        $data = Document::find($id);
        $data->status = Document::PREPARE_ROOTING_REVIEW;
        $data->save();

        // update activity
        $this->update_activity([
            'id' => $id,
            'status' => $data->status,
        ]);
    }

    /**
     * Function to approved document
     */
    public function submit_document($id)
    {
        $data = Document::with(['attachments' => function ($query) {
            $query->where('status', 1);
        }])
            ->find($id);

        $files = $data->attachments->toArray();
        if (count($files) > 0) {
            $needs_watermark = false;
            foreach ($files as $file) {
                if (strpos($file['file_name'], 'Final-') !== 0) {
                    $needs_watermark = true;
                    break;
                }
            }
            if ($needs_watermark) {
                $this->handle_document_rooting_approval($files, $id, true);
            }
        }
        $data->status = Document::ACTIVE;
        $data->save();

        // update activity
        $this->update_activity([
            'id' => $id,
            'status' => $data->status,
        ]);

        // update parent document
        if ($data->related_document_id) {
            $parent = Document::find($data->related_document_id);
            $parent->status = Document::OBSOLATE;
            $parent->save();
        }

        return $data;
    }

    /**
     * Function to replicate document
     */
    public function replicate($id)
    {
        $document = Document::with('attachments')
            ->find($id);
        $current_history = $document->history_revision;
        if (!$current_history) {
            $history = [$document->doc_created];
        } else {
            $history = array_merge(json_decode($current_history, true), [$document->doc_created]);
        }
        $current_revision = $document->revision ?? 0;

        $new = $document->replicate();
        $new->doc_created = date('Y-m-d');
        $new->status = Document::DRAFT;
        $new->related_document_id = $id;
        $new->revision = (int) $current_revision + 1;
        $new->history_revision = json_encode($history);
        if ($new->save()) {
            $document->is_obsolate = true;
            $document->save();
        }

        return $new;
    }

    /**
     * Function to store static data through terminal command
     */
    public function set_template_data($last_step = 'active')
    {
        DB::beginTransaction();

        try {
            $company = Company::select('id', 'company_name', 'document_code')
                ->with(['departments:id,company_id,name,code,id'])
                ->latest()
                ->first();
            $mapping = Mapping::latest()->first();
            $department = $company->departments[0];
            $pic = User::select('id')
                ->where('department_id', $department->id)
                ->first();
            $random_maker = User::latest()->first();

            $document = new Document();
            $document->department_id = $department->id;
            $document->mapping_id = $mapping->id;
            $document->user_id = $pic->id;
            $document->upload_type = 'document';
            $document->document_level = Document::SOP_DOC_TYPE;
            $document->status = Document::WAITNG_REVIEW;
            $document->title = 'Document testing for ' . fake()->firstName();
            $document->description = 'Description for testing';
            $document->sop_number = fake()->randomDigitNotZero() . fake()->randomDigitNotZero();
            $document->doc_created = date('Y-m-d');
            $document->created_by = auth()->id() ?? $random_maker->id;
            $document->save();

            // attachments
            $files = [
                'sapiens.png', 'testingtesting.docx',
            ];
             for ($a = 0; $a < count($files); $a++) {
                 if (!Storage::disk('public')->exists('document_systems/' . $document->id)) {
                     Storage::disk('public')->makeDirectory('document_systems/' . $document->id);
                 }
                 if (!File::exists(public_path('storage/document_systems/' . $document->id . '/' . $files[$a]))) {
                     File::copy(public_path('images/template/' . $files[$a]), public_path('storage/document_systems/' . $document->id . '/' . $files[$a]));
                 }
                $media = new Attachment();
                $media->document_id = $document->id;
                $media->file_name = $files[$a];
                $media->file_type = 'png';
                $media->file_size = 0.877;
                $media->path = public_path('storage/document_systems/' . $document->id . '/' . $files[$a]);
                $media->save();
            }

            // peoples

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Helper to detect PDF page orientation (portrait or landscape)
     * @param string $pdfPath
     * @return string 'portrait'|'landscape'
     */
    private function detect_pdf_orientation($pdfPath)
    {
        if (!file_exists($pdfPath)) {
            return 'portrait';
        }

        $content = file_get_contents($pdfPath);

        // 1. Try plaintext MediaBox or CropBox
        $pattern = '/\/(MediaBox|CropBox)\s*\[\s*([0-9.-]+)\s+([0-9.-]+)\s+([0-9.-]+)\s+([0-9.-]+)\s*\]/i';
        if (preg_match_all($pattern, $content, $matches)) {
            foreach ($matches[4] as $idx => $widthVal) {
                $width = (float)$widthVal;
                $height = (float)$matches[5][$idx];
                if ($width > 0 && $height > 0) {
                    return ($width > $height) ? 'landscape' : 'portrait';
                }
            }
        }

        // 2. Try inside compressed streams (max 20 streams to keep it extremely fast)
        $offset = 0;
        $stream_count = 0;
        $stream_limit = 20;
        while (($pos = strpos($content, "stream", $offset)) !== false) {
            $end_pos = strpos($content, "endstream", $pos);
            if ($end_pos === false) {
                break;
            }

            $stream_count++;
            if ($stream_count > $stream_limit) {
                break;
            }

            $data_start = $pos + 6;
            while ($data_start < $end_pos && ($content[$data_start] === "\r" || $content[$data_start] === "\n")) {
                $data_start++;
            }

            $data_len = $end_pos - $data_start;
            while ($data_len > 0 && ($content[$data_start + $data_len - 1] === "\r" || $content[$data_start + $data_len - 1] === "\n")) {
                $data_len--;
            }

            if ($data_len > 0) {
                $stream_data = substr($content, $data_start, $data_len);
                $decompressed = @gzuncompress($stream_data);
                if ($decompressed === false) {
                    $decompressed = @gzinflate($stream_data);
                }
                if ($decompressed === false && strlen($stream_data) > 2) {
                    $decompressed = @gzinflate(substr($stream_data, 2));
                }

                if ($decompressed !== false) {
                    if (preg_match($pattern, $decompressed, $subMatches)) {
                        $width = (float)$subMatches[4];
                        $height = (float)$subMatches[5];
                        if ($width > 0 && $height > 0) {
                            return ($width > $height) ? 'landscape' : 'portrait';
                        }
                    }
                }
            }
            $offset = $end_pos + 9;
        }

        return 'portrait';
    }
}
