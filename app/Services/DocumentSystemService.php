<?php

namespace App\Services;

use App\Jobs\NotifyCreateDocument;
use App\Models\DocumentSystem\Activity;
use App\Models\DocumentSystem\ActivityAttachment;
use App\Models\DocumentSystem\Attachment;
use App\Models\DocumentSystem\Document;
use App\Models\DocumentSystem\InvitedPeople;
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
                ->where('email', $peoples[$a])
                ->first();
            $type = InvitedPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = InvitedPeople::USER_INSIDE_OFFICE;
            }

            $model = new InvitedPeople();
            $model->user_id = $user ? $user->id : null;
            $model->document_id = $document->id;
            $model->user_type = $type;
            $model->email = $peoples[$a];
            $model->is_notify_email = $data['is_notify_email'];
            $model->save();
        }

        // handle document
        for ($b = 0; $b < count($documents); $b++) {
            if (File::exists(public_path('storage/tmp/document_systems/' . $documents[$b]['name']))) {
                if (!File::exists(public_path('storage/document_systems/' . $document->id))) {
                    Storage::makeDirectory('public/document_systems/' . $document->id);
                }

                File::move(public_path('storage/tmp/document_systems/' . $documents[$b]['name']), public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']));

                $model_document = new Attachment();
                $model_document->document_id = $document->id;
                $model_document->file_name = $documents[$b]['name'];
                $model_document->file_size = $documents[$b]['size'];
                $model_document->file_type = $documents[$b]['ext'];
                $model_document->path = public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']);
                $model_document->save();

                File::delete(public_path('storage/tmp/document_systems/' . $documents[$b]['name']));
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

        $document = Document::find($id);
        $current_status = $document->status;

        // delete and insert peoples
        for ($a = 0; $a < count($peoples); $a++) {
            $people_to_be_delete = InvitedPeople::select('id')
                ->where('document_id', $id)
                ->where('email', '!=', $peoples[$a])
                ->get();
            if (count($people_to_be_delete) > 0) {
                for ($b = 0; $b < count($people_to_be_delete); $b++) {
                    InvitedPeople::where('id', $people_to_be_delete[$b]->id)
                        ->delete();
                }
            }

            $user = User::select('email', 'id')
                ->where('email', $peoples[$a])
                ->first();
            $type = InvitedPeople::USER_OUTSIDE_OFFICE;
            if ($user) {
                $type = InvitedPeople::USER_INSIDE_OFFICE;
            }

            $people = InvitedPeople::where('document_id', $id)
                ->where('email', $peoples[$a])
                ->first();
            if (!$people) {
                $people = new InvitedPeople();
            }
            $people->is_notify_email = $is_notify;
            $people->email = $peoples[$a];
            $people->user_type = $type;
            $people->document_id = $id;
            $people->user_id = $user ? $user->id : null;
            $people->save();
        }

        $document->title = $data['title'];
        $document->department_id = $data['department_id'];
        $document->mapping_id = $data['mapping_id'];
        $document->upload_type = $data['upload_type'];
        $document->document_level = $data['document_type'];
        $document->status = $data['status'];
        $document->description = $data['description'];
        $document->sop_number = $data['sop_number'] ?? null;
        $document->sop_add_win = $data['win_number'] ?? null;
        $document->document_number = $data['form_number'] ?? null;
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
                    if (File::exists($current_media->path)) {
                        File::delete($current_media->path);
                    }
                    $current_media->delete();
                }
            }

            for ($b = 0; $b < count($documents); $b++) {
                if (File::exists(public_path('storage/tmp/document_systems/' . $documents[$b]['name']))) {
                    if (!File::exists(public_path('storage/document_systems/' . $document->id))) {
                        Storage::makeDirectory('public/document_systems/' . $document->id);
                    }

                    File::move(public_path('storage/tmp/document_systems/' . $documents[$b]['name']), public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']));

                    $model_document = new Attachment();
                    $model_document->document_id = $document->id;
                    $model_document->file_name = $documents[$b]['name'];
                    $model_document->file_size = $documents[$b]['size'];
                    $model_document->file_type = $documents[$b]['ext'];
                    $model_document->path = public_path('storage/document_systems/' . $document->id . '/' . $documents[$b]['name']);
                    $model_document->save();

                    File::delete(public_path('storage/tmp/document_systems/' . $documents[$b]['name']));
                }
            }
        }

        // update activity
        $this->update_activity([
            'status' => $data['status'],
            'id' => $id,
        ]);
    }

    /**
     * Function to handle document upload when maker submit for rooting approval
     */
    // public function handle_document_rooting_approval($files, $id, $add_watermark)
    // {
    //     // update status current attachment to inactive
    //     Attachment::where('document_id', $id)
    //         ->update(['status' => false]);

    //     // add watermark to file request and move to desire folder
    //     for ($a = 0; $a < count($files); $a++) {
    //         $pdf = new Fpdi();
    //         if (isset($files[$a]['id'])) {
    //             $file = public_path('storage/document_systems/' . $id . '/' . $files[$a]['file_name']);
    //         } else {
    //             $file = public_path('storage/tmp/document_systems/' . $files[$a]['file_name']);
    //         }
    //         $text_image  = public_path('images/watermark.png');

    //         if (File::exists($file)) {
    //             $pagecount = $pdf->setSourceFile($file);
    //         } else {
    //             return $files[$a]['file_name'] . ' file not exist';
    //         }

    //         // Add watermark image to PDF pages
    //         for ($i = 1; $i <= $pagecount; $i++) {
    //             $tpl = $pdf->importPage($i);
    //             $size = $pdf->getTemplateSize($tpl);
    //             $pdf->addPage();
    //             $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE);

    //             //Put the watermark
    //             $xxx_final = ($size['width'] - 160);
    //             $yyy_final = ($size['height'] - 225);
    //             if ($add_watermark) {
    //                 $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png');
    //             }
    //         }

    //         // Output PDF with watermark
    //         if ($add_watermark) {
    //             $final_filename = 'Final-' . $files[$a]['file_name'];
    //         } else {
    //             $final_filename = $files[$a]['file_name'];
    //         }
    //         $pdf->Output('F', 'storage/document_systems/' . $id . '/' . $final_filename);

    //         $model_document = new Attachment();
    //         $model_document->document_id = $id;
    //         $model_document->file_name = $final_filename;
    //         $model_document->file_size = $files[$a]['file_size'];
    //         $model_document->file_type = $files[$a]['file_type'];
    //         $model_document->path = public_path('storage/document_systems/' . $id . '/' . $final_filename);
    //         $model_document->save();
    //     }
    // }

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

        $destination_dir = public_path('storage/document_systems/' . $id . '/');

        // Pastikan direktori tujuan ada
        if (!File::isDirectory($destination_dir)) {
            File::makeDirectory($destination_dir, 0755, true);
        }

        $text_image = public_path('images/watermark.png');

        // Validasi file watermark sebelum looping
        if ($add_watermark && !File::exists($text_image)) {
            return 'Watermark image tidak ditemukan: ' . $text_image;
        }

        for ($a = 0; $a < count($files); $a++) {
            if (isset($files[$a]['id'])) {
                $file = public_path('storage/document_systems/' . $id . '/' . $files[$a]['file_name']);
            } else {
                $file = public_path('storage/tmp/document_systems/' . $files[$a]['file_name']);
            }

            if ($add_watermark) {
                if (strpos($files[$a]['file_name'], 'Final-') === 0) {
                    $final_filename = $files[$a]['file_name'];
                } else {
                    $final_filename = 'Final-' . $files[$a]['file_name'];
                }
            } else {
                $final_filename = $files[$a]['file_name'];
            }
            $output_file = $destination_dir . $final_filename;

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

                        for ($i = 1; $i <= $pagecount; $i++) {
                            $tpl = $pdf->importPage($i);
                            $size = $pdf->getTemplateSize($tpl);
                            $pdf->addPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                            $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

                            if ($add_watermark) {
                                $xxx_final = ($size['width'] - 160);
                                $yyy_final = ($size['height'] - 225);
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
            $model_document->path = $output_file;
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

                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('scratch.test_watermark', $data)
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
                if (!File::exists(public_path('storage/' . $target_path))) {
                    Storage::makeDirectory('public/' . $target_path);
                }
                File::move(public_path('storage/tmp/document_systems/' . $files[$a]['name']), public_path('storage/' . $target_path . '/' . $files[$a]['name']));
                $res[] = [
                    'path' => asset($target_path . '/' . $files[$a]['name']),
                    'name' => $files[$a]['name'],
                    'file_size' => $files[$a]['size'],
                    'ext' => $files[$a]['ext'],
                ];

                File::delete(public_path('storage/tmp/document_systems/' . $files[$a]['name']));
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
        $fix_size = round($size / 1024 / 1024, 4);

        // save file to tmp
        $name = date('Y-m-d') . '-' . $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $ext_path = asset('images/icons/pdf.png');
        $img_preview = null;
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
            $img_preview = asset('storage/tmp/document_systems/' . $name);
        }
        $ext_path = $this->define_file_icon($ext);
        $save = Storage::putFileAs('public/tmp/document_systems', $file, $name);

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

        $upload = $this->move_file($files, 'document_systems/' . $data['id'] . '/revision');
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
    }

    /**
     * Function to replicate document
     */
    public function replicate($id)
    {
        $document = Document::with('attachments')
            ->find($id);
        $current_media = $document->attachments;
        $current_revision = $document->revision ?? 0;
        $new = $document->replicate();
        $new->doc_created = date('Y-m-d');
        $new->status = Document::DRAFT;
        $new->related_document_id = $id;
        $new->revision = (int) $current_revision + 1;
        $new->save();

        return $new;
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
