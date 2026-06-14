<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pdf_path = public_path('storage/document_systems/a205245a-7c6b-4551-8470-8da66fb6dd75/2026-06-14-1634-testing.pdf');

if (!file_exists($pdf_path)) {
    die("File does not exist\n");
}

$content = file_get_contents($pdf_path);

// Let's find all instances of stream/endstream
$offset = 0;
$stream_count = 0;
while (($pos = strpos($content, "stream", $offset)) !== false) {
    $end_pos = strpos($content, "endstream", $pos);
    if ($end_pos === false) {
        break;
    }
    
    // The stream data is between the newline after "stream" and "endstream"
    $data_start = $pos + 6;
    // Skip any leading whitespace (CR/LF)
    while ($data_start < $end_pos && ($content[$data_start] === "\r" || $content[$data_start] === "\n")) {
        $data_start++;
    }
    
    $data_len = $end_pos - $data_start;
    // Strip trailing CR/LF if present
    while ($data_len > 0 && ($content[$data_start + $data_len - 1] === "\r" || $content[$data_start + $data_len - 1] === "\n")) {
        $data_len--;
    }
    
    if ($data_len > 0) {
        $stream_data = substr($content, $data_start, $data_len);
        $decompressed = @gzuncompress($stream_data);
        if ($decompressed === false) {
            $decompressed = @gzinflate($stream_data);
        }
        if ($decompressed === false) {
            // Try with @gzinflate after stripping some headers
            $decompressed = @gzinflate(substr($stream_data, 2));
        }
        
        if ($decompressed !== false) {
            $stream_count++;
            if (strpos($decompressed, '/MediaBox') !== false || strpos($decompressed, '/CropBox') !== false) {
                echo "Stream {$stream_count} contains MediaBox/CropBox!\n";
                echo "Content:\n" . substr($decompressed, 0, 500) . "\n\n";
            }
        }
    }
    
    $offset = $end_pos + 9;
}

// Let's also look for plain text MediaBox
if (preg_match_all('/\/MediaBox\s*\[\s*([0-9.-]+)\s+([0-9.-]+)\s+([0-9.-]+)\s+([0-9.-]+)\s*\]/', $content, $matches)) {
    echo "Plain text MediaBox found:\n";
    print_r($matches);
} else {
    echo "No plain text MediaBox found.\n";
}
