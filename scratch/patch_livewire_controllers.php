<?php

$dir = realpath(__DIR__ . '/../Modules/Audit/Http/Livewire');
if (!$dir) {
    die("Directory not found\n");
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $files[] = $file->getPathname();
    }
}

echo "Found " . count($files) . " PHP files.\n";

$patchedCount = 0;

foreach ($files as $filePath) {
    $content = file_get_contents($filePath);
    $original = $content;

    // We search for saveDoc function and store() call inside it
    if (strpos($content, 'function saveDoc') !== false && strpos($content, '->doc->store(') !== false) {
        // Let's identify if it is Glossary or normal attachment
        if (strpos($content, 'AuditGlossary::create') !== false) {
            // It is glossary!
            // Let's match:
            // $url = $this->doc->store('storage/public/'.strtolower($this->audit_category)."/glossary");
            // AuditGlossary::create([
            //     'audit_category'=>$this->audit_category,
            //     'document_name'=>$this->document_name,
            //     'url'=>$url
            // ]);
            
            $patternStore = '/(\$url\s*=\s*\$this->doc->store\(([^)]+)\);)/';
            $replacementStore = "$1\n                \$tempPath = \$this->doc->getRealPath();\n                \$blobResult = uploadToBlobStorage(\$this->doc->getClientOriginalName(), \$tempPath, 'audit/glossary');";
            
            $content = preg_replace($patternStore, $replacementStore, $content);
            
            // Now patch AuditGlossary::create
            $patternCreate = "/AuditGlossary::create\(\[\s*'audit_category'\s*=>\s*\\\$this->audit_category,\s*'document_name'\s*=>\s*\\\$this->document_name,\s*'url'\s*=>\s*\\\$url\s*\]\)/";
            $replacementCreate = "AuditGlossary::create([\n                        'audit_category'=>\$this->audit_category,\n                        'document_name'=>\$this->document_name,\n                        'url'=>\$url,\n                        'blob_url' => \$blobResult['fileBlobUrl'] ?? null,\n                        'blob_response' => isset(\$blobResult['blobResponse']) ? json_encode(\$blobResult['blobResponse']) : null,\n                    ])";
            
            $content = preg_replace($patternCreate, $replacementCreate, $content);
        } else {
            // It is a normal attachment!
            // Let's match:
            // $image = $this->doc->store('storage/public/smkp/' . $this->audit->id . "/notice-letter");
            // $this->audit->notice_letters()->create(['original_name'=>$this->doc->getClientOriginalName(),'url' => $image, 'status' => SubBundleStatusEnum::SUBMITTED]);
            // (Note: category, folder name, and relation change depending on the folder, e.g., $this->audit->opening_attendances()->create(...))
            
            // First let's find what relation is being called: e.g. notice_letters, opening_attendances, closing_attendances, response_audits, report_results, another_attachments
            preg_match('/\$this->audit->([a-zA-Z0-9_]+)\(\)->create/', $content, $relMatch);
            if (!empty($relMatch)) {
                $relation = $relMatch[1];
                
                // Let's determine the module folder name/slug
                preg_match('/\$this->doc->store\([\'"]storage\/public\/[^\/]+\/\'\s*\.\s*\\\$this->audit->id\s*\.\s*[\'"]\/([^\'"]+)[\'"]\)/', $content, $folderMatch);
                if (empty($folderMatch)) {
                    // Try without ID (different format)
                    preg_match('/\$this->doc->store\([\'"]storage\/public\/[^\/]+\/\'\s*\.\s*\\\$this->audit->id\s*\.\s*[\'"]\/([^\'"]+)[\'"]\)/', $content, $folderMatch);
                }
                
                $folder = !empty($folderMatch) ? $folderMatch[1] : 'attachment';
                
                // Let's match the store line:
                // $image = $this->doc->store('storage/public/smkp/' . $this->audit->id . "/notice-letter");
                $patternStore = '/(\$image\s*=\s*\$this->doc->store\(([^)]+)\);)/';
                $replacementStore = "$1\n                \$tempPath = \$this->doc->getRealPath();\n                \$blobResult = uploadToBlobStorage(\$this->doc->getClientOriginalName(), \$tempPath, 'audit/' . \$this->audit->id . '/" . $folder . "');";
                
                $content = preg_replace($patternStore, $replacementStore, $content);
                
                // Now match the create line:
                // $this->audit->notice_letters()->create(['original_name'=>$this->doc->getClientOriginalName(),'url' => $image, 'status' => SubBundleStatusEnum::SUBMITTED]);
                $patternCreate = '/\$this->audit->' . $relation . '\(\)->create\(\s*\[\s*([^]]+)\s*\]\s*\)/';
                $replacementCreate = "\$this->audit->" . $relation . "()->create([\n                    $1,\n                    'blob_url' => \$blobResult['fileBlobUrl'] ?? null,\n                    'blob_response' => isset(\$blobResult['blobResponse']) ? json_encode(\$blobResult['blobResponse']) : null,\n                ])";
                
                $content = preg_replace($patternCreate, $replacementCreate, $content);
            }
        }
        
        if ($content !== $original) {
            file_put_contents($filePath, $content);
            echo "Patched: " . basename($filePath) . " ($filePath)\n";
            $patchedCount++;
        }
    }
}

echo "Successfully patched $patchedCount files.\n";
