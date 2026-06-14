<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Attachment;

function detect_pdf_orientation($pdfPath) {
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

$id = 'a205245a-7c6b-4551-8470-8da66fb6dd75';
$files = [
    [
        'id' => 'a205245a-7c6b-4551-8470-8da66fb6dd75',
        'file_name' => '2026-06-14-1634-testing.pdf',
        'file_size' => 476506,
        'file_type' => 'pdf',
    ]
];
$add_watermark = true;

// Mock the handle_document_rooting_approval function in scratch script:
echo "Starting test_watermark simulation...\n";

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
try {
    Attachment::where('document_id', $id)
        ->update(['status' => false]);
    echo "Deactivated old attachments in DB.\n";
} catch (\Throwable $e) {
    echo "Database error (continuing without db updates): " . $e->getMessage() . "\n";
}

$document = Document::find($id);
if ($document) {
    echo "Found document in DB: " . $document->title . "\n";
} else {
    echo "Document not found in database. Using mock document data.\n";
    $document = new stdClass();
    $document->title = 'Mock Test Document';
    $document->description = 'Mock description for watermark testing.';
}

// add watermark to file request and move to desire folder
for ($a = 0; $a < count($files); $a++) {
    if (isset($files[$a]['id'])) {
        $file = public_path('storage/document_systems/' . $id . '/' . $files[$a]['file_name']);
    } else {
        $file = public_path('storage/tmp/document_systems/' . $files[$a]['file_name']);
    }
    $text_image  = public_path('images/watermark.png');

    echo "Checking source file: " . $file . "\n";
    echo "Source exists: " . (File::exists($file) ? 'Yes' : 'No') . "\n";

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
    echo "Output file path: " . $output_file . "\n";

    // Ensure destination directory exists
    $destination_dir = dirname($output_file);
    if (!File::exists($destination_dir)) {
        File::makeDirectory($destination_dir, 0755, true);
        echo "Created destination directory: " . $destination_dir . "\n";
    }

    $watermark_success = false;
    $already_watermarked = ($add_watermark && strpos($files[$a]['file_name'], 'Final-') === 0);

    if ($already_watermarked) {
        if (File::exists($file)) {
            if ($file !== $output_file) {
                File::copy($file, $output_file);
            }
            $watermark_success = true;
            echo "Already watermarked. Copied file directly.\n";
        }
    } else {
        if (File::exists($file)) {
            try {
                // Detect orientation from the source PDF
                $orientation = detect_pdf_orientation($file);
                echo "Detected PDF orientation: " . $orientation . "\n";

                $data = [
                    'watermark'  => $text_image,
                ];

                $pdf = Pdf::loadView('scratch.test_watermark', $data)
                    ->setPaper('a4', $orientation);

                $pdf->save($output_file);
                $watermark_success = true;
                echo "Successfully generated PDF via DomPDF!\n";
            } catch (\Throwable $e) {
                echo "DomPDF generation failed: " . $e->getMessage() . "\n";
            }
        }
    }

    if (!$watermark_success) {
        // Fallback: copy the original file directly to output file destination without watermark
        if (File::exists($file)) {
            File::copy($file, $output_file);
            echo "Fallback triggered: copied original file directly.\n";
        } else {
            echo "Error: file " . $files[$a]['file_name'] . " does not exist.\n";
        }
    }
}
