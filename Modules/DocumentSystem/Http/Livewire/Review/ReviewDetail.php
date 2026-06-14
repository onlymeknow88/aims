<?php

namespace Modules\DocumentSystem\Http\Livewire\Review;

use App\Enums\DocumentSystem\DocumentStatus;
use Modules\DocumentSystem\Entities\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

class ReviewDetail extends Component
{
    use WithFileUploads;

    public $document;
    public $attachs = [];
    public $description = '';
    public $user;
    public $approved = false;

    public function mount(Request $request)
    {

        $this->document = Document::with([
            'department.company',
            'areaManager' => function ($q) {
                $q->with(['user', 'section']);
            },
            'mapping.category.module',
            'activities.user',
            'attachments'
        ])->find($request->id);

        $this->approved = $this->document->hasRoutingApproval();
        $this->user = User::latest()->first();
    }

    public function render()
    {
        return view('documentsystem::livewire.review.review-detail')->extends('documentsystem::layouts.no-header');
    }

    public function saveToReturn()
    {
        // store file if exists
        if ($this->attachs) {
            foreach ($this->attachs as $key => $file) {
                list($fileUpload, $mime) = explode(".", $file->getFileName());
                $filename = date('Y-m-d-H-i-s') . '-' . Str::slug($this->document->title, '-') . $key . '.' . $mime;
                $this->attachs[$key] = $file->storeAs('document-systems-files/activity', $filename);
            }
        }

        //update document status to return
        $this->document->updateToReturn();

        //input data activity
        $activity = [
            'description' => $this->description,
            'user_id' => $this->user->id,
            'status_document' => DocumentStatus::Return()->value
        ];

        if ($this->attachs) {
            $activity['attachments'] = json_encode($this->attachs);
        }

        $this->document->activities()->create($activity);

        return redirect()->route('document-systems::review');
    }

    public function saveToRoutingApproval()
    {
        $this->document->updateToRoutingApproved();
        $this->description = 'Document status Routing Approval';
        //input data activity
        $activity = [
            'description' => $this->description,
            'user_id' => $this->user->id,
            'status_document' => DocumentStatus::RoutingApproval()->value
        ];
        $this->document->activities()->create($activity);

        return redirect()->route('document-systems::review');
    }

    public function saveToApproved()
    {
        // dd('a');
        $file = $this->document->attachments()->latest()->first();
        $uncontrolledFile = $this->setWaterMark($file);

        $this->document->updateToApproved([
            'file_path' => $file->path,
            'uncontrolled_file_path' => $uncontrolledFile
        ]);
        $this->description = 'Document status Approved';
        //input data activity
        $activity = [
            'description' => $this->description,
            'user_id' => $this->user->id,
            'status_document' => DocumentStatus::Approved()->value,
        ];
        $this->document->activities()->create($activity);

        return redirect()->route('document-systems::review');
    }

    protected function setWaterMark($attach)
    {
        $file = public_path($attach->path);
        $text_image = public_path('images/uncontrolled.png');

        // Output PDF with watermark 
        $path = 'app/document-systems-files/uncontrolled/';
        $storagePath = storage_path($path);
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $fileOutput = storage_path($path . $attach->file_name);
        $watermark_success = false;

        if (file_exists($file)) {
            try {
                // Set source PDF file 
                $pdf = new Fpdi();
                $pagecount = $pdf->setSourceFile($file);

                // Add watermark image to PDF pages 
                for ($i = 1; $i <= $pagecount; $i++) {
                    $tpl = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($tpl);
                    $pdf->addPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                    $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

                    //Put the watermark 
                    $xxx_final = ($size['width'] - 170);
                    $yyy_final = ($size['height'] - 200);
                    if (file_exists($text_image)) {
                        $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png');
                    }
                }
                $pdf->Output('F', $fileOutput);
                $watermark_success = true;
            } catch (\Throwable $e) {
                \Log::warning("Review uncontrolled watermarking failed for file {$attach->file_name}. Falling back to copying original file. Error: " . $e->getMessage());
            }
        }

        if (!$watermark_success) {
            // Fallback: Copy file directly without watermark
            if (file_exists($file)) {
                copy($file, $fileOutput);
            }
        }

        return 'document-systems-files/uncontrolled/' . $attach->file_name;
    }
}
