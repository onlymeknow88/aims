<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

$audit = Audit::where('title', 'like', 'Dummy Audit SMKP - On Progress Scenario')->first();
if (!$audit) {
    echo "Audit not found!\n";
    exit(1);
}

echo "Audit ID: " . $audit->id . "\n";
echo "Listing all Sub-Criteria in this audit with children count and sample methods count:\n\n";

$subCriteriaList = AuditSubCriteria::whereHas('criteria.module', function($q) use ($audit) {
    $q->where('audit_id', $audit->id);
})->get();

foreach ($subCriteriaList as $sub) {
    $childrenCount = $sub->children()->count();
    $methodsCount = $sub->sample_methods()->count();
    if ($childrenCount > 0 || $methodsCount > 0) {
        echo sprintf(
            "Sub-Criteria: %s (ID: %s)\n  Children count: %d\n  Sample methods count: %d\n  Parent ID: %s\n\n",
            $sub->title,
            $sub->id,
            $childrenCount,
            $methodsCount,
            $sub->parent_id ?? 'None'
        );
    }
}
