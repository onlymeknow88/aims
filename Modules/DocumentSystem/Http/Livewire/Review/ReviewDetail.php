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
        $temp_download_file = null;

        // If the file is stored in Blob Storage, download it locally first
        if (!empty($attach->blob_url)) {
            $url = $attach->blob_url;
            if (strpos($url, 'blob.core.windows.net') !== false) {
                $parsedUrl = parse_url($url);
                $path = ltrim($parsedUrl['path'] ?? '', '/');
                $parts = explode('/', $path, 2);
                if (count($parts) === 2) {
                    $container = $parts[0];
                    // Normalize double slashes and decode %20 so Azure SAS API can match the actual filename
                    $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));
                    $sasResult = GetBlobSasUri($container, $filePath, 15);
                    if ($sasResult && !empty($sasResult['blobUriSas'])) {
                        $url = $sasResult['blobUriSas'];
                    }
                }
            }
            try {
                $fileContent = file_get_contents($url);
                if ($fileContent !== false) {
                    $temp_download_file = storage_path('app/tmp/downloaded_' . uniqid() . '_' . $attach->file_name);
                    if (!\Illuminate\Support\Facades\File::exists(dirname($temp_download_file))) {
                        \Illuminate\Support\Facades\File::makeDirectory(dirname($temp_download_file), 0755, true);
                    }
                    \Illuminate\Support\Facades\File::put($temp_download_file, $fileContent);
                    $file = $temp_download_file;
                }
            } catch (\Exception $e) {
                \Log::error("setWaterMark: Failed to download source file from blob: " . $e->getMessage());
            }
        }

        // Temp output path sebelum upload ke blob
        $path = 'app/tmp/document-systems-files/uncontrolled/';
        $storagePath = storage_path($path);
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $fileOutput = storage_path($path . $attach->file_name);
        $watermark_success = false;

        if (file_exists($file)) {
            try {
                $scriptPath = app_path('Helpers/watermark.py');
                $cmd = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($file) . " " . escapeshellarg($fileOutput) . " " . escapeshellarg($text_image) . " review";
                $outputCmd = [];
                $returnVar = -1;
                exec($cmd, $outputCmd, $returnVar);

                if ($returnVar === 0) {
                    $watermark_success = true;
                } else {
                    \Log::warning("Python watermarking script returned error code {$returnVar}. Output: " . implode("\n", $outputCmd));
                }
            } catch (\Throwable $e) {
                \Log::warning("Python watermarking failed for file {$attach->file_name}. Falling back to copying original file. Error: " . $e->getMessage());
            }
        }

        // Fallback: copy original jika watermark gagal
        if (!$watermark_success) {
            if (file_exists($file)) {
                copy($file, $fileOutput);
                $watermark_success = true;
            } else {
                \Log::error("setWaterMark: source file not found for {$attach->file_name}");
            }
        }

        // Hapus file temp download sumber jika ada
        if ($temp_download_file && file_exists($temp_download_file)) {
            unlink($temp_download_file);
        }

        // UPLOAD KE BLOB STORAGE
        $uncontrolled_path = 'document-systems-files/uncontrolled/' . $attach->file_name;
        if ($watermark_success && file_exists($fileOutput)) {
            $directPath = 'document-systems-files/uncontrolled/';
            $blobResult = uploadToBlobStorage(
                $attach->file_name,   // filename
                $fileOutput,          // filePathTemp (local file hasil watermark)
                $directPath           // folder di blob
            );

            // Hapus file temp lokal setelah upload
            unlink($fileOutput);

            if ($blobResult['fileBlobUrl']) {
                $uncontrolled_path = $blobResult['fileBlobUrl']; // Simpan URL blob langsung ke uncontrolled_file_path
            } else {
                \Log::warning("setWaterMark: Blob upload failed for file {$attach->file_name}.");
            }
        }

        return $uncontrolled_path;
    }

// /**
//      * Function to handle document upload when maker submit for rooting approval BlobStorage
//      */
//     /*
//     protected function setWaterMark($attach)
// {
//     $file = public_path($attach->path);
//     $text_image = public_path('images/uncontrolled.png');

//     // Temp output path sebelum upload ke blob
//     $path = 'app/tmp/document-systems-files/uncontrolled/';
//     $storagePath = storage_path($path);
//     if (!is_dir($storagePath)) {
//         mkdir($storagePath, 0755, true);
//     }

//     $fileOutput = storage_path($path . $attach->file_name);
//     $watermark_success = false;

//     if (file_exists($file)) {
//         try {
//             $orientation = $this->detect_pdf_orientation($file);
//             $data = [
//                 'watermark' => $text_image,
//             ];

//             $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('document_system_final.final_pdf', $data)
//                 ->setPaper('a4', $orientation);

//             $pdf->save($fileOutput);
//             $watermark_success = true;
//         } catch (\Throwable $e) {
//             \Log::warning("DomPDF watermarking failed for file {$attach->file_name}. Falling back to copying original file. Error: " . $e->getMessage());
//         }
//     }

//     // Fallback: copy original jika watermark gagal
//     if (!$watermark_success) {
//         if (file_exists($file)) {
//             copy($file, $fileOutput);
//         } else {
//             \Log::error("setWaterMark: source file not found for {$attach->file_name}");
//             return null;
//         }
//     }

//     // ============================================================
//     // UPLOAD KE BLOB STORAGE
//     // ============================================================
//     $directPath = 'document-systems-files/uncontrolled/';

//     $blobResult = uploadToBlobStorage(
//         $attach->file_name,   // filename
//         $fileOutput,          // filePathTemp (local file hasil watermark)
//         $directPath           // folder di blob
//     );

//     // Hapus file temp lokal setelah upload
//     if (file_exists($fileOutput)) {
//         unlink($fileOutput);
//     }

//     // Log warning jika blob upload gagal
//     if (!$blobResult['fileBlobUrl']) {
//         \Log::warning("setWaterMark: Blob upload failed for file {$attach->file_name}.");
//     }

//     return [
//         'path'          => 'document-systems-files/uncontrolled/' . $attach->file_name,
//         'blob_url'      => $blobResult['fileBlobUrl'] ?? null,
//         'blob_path'     => $blobResult['fileBlobPathName'] ?? null,
//         'blob_response' => $blobResult['blobResponse'] ?? null,
//     ];
// }

    // protected function setWaterMark($attach)
    // {
    //     $file = public_path($attach->path);
    //     $text_image = public_path('images/uncontrolled.png');

    //     // Output PDF with watermark
    //     $path = 'app/document-systems-files/uncontrolled/';
    //     $storagePath = storage_path($path);
    //     if (!is_dir($storagePath)) {
    //         mkdir($storagePath, 0755, true);
    //     }

    //     $fileOutput = storage_path($path . $attach->file_name);
    //     $watermark_success = false;

    //     if (file_exists($file)) {
    //         try {
    //             // Set source PDF file
    //             $pdf = new Fpdi();
    //             $pagecount = $pdf->setSourceFile($file);

    //             // Add watermark image to PDF pages
    //             for ($i = 1; $i <= $pagecount; $i++) {
    //                 $tpl = $pdf->importPage($i);
    //                 $size = $pdf->getTemplateSize($tpl);
    //                 $pdf->addPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
    //                 $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

    //                 //Put the watermark
    //                 $xxx_final = ($size['width'] - 170);
    //                 $yyy_final = ($size['height'] - 200);
    //                 if (file_exists($text_image)) {
    //                     $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png');
    //                 }
    //             }
    //             $pdf->Output('F', $fileOutput);
    //             $watermark_success = true;
    //         } catch (\Throwable $e) {
    //             \Log::warning("Review uncontrolled watermarking failed for file {$attach->file_name}. Falling back to copying original file. Error: " . $e->getMessage());
    //         }
    //     }

    //     if (!$watermark_success) {
    //         // Fallback: Copy file directly without watermark
    //         if (file_exists($file)) {
    //             copy($file, $fileOutput);
    //         }
    //     }

    //     return 'document-systems-files/uncontrolled/' . $attach->file_name;
    // }
}
