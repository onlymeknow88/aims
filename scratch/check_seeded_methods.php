<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Audit\Entities\Audit;
use Illuminate\Support\Facades\DB;

foreach (Audit::where('title', 'like', 'Dummy Audit%')->get() as $a) {
    echo "Audit: {$a->title} ({$a->id})\n";
    $subCriteriaIds = \Modules\Audit\Entities\AuditSubCriteria::whereIn(
        'audit_criteria_id', 
        $a->criteria_module->criteria()->pluck('id')
    )->pluck('id');
    
    $methods = DB::table('audit_sub_criteria_sample_methods')
        ->whereIn('audit_sub_criteria_id', $subCriteriaIds)
        ->get();
        
    echo "  Seeded Methods count: " . $methods->count() . "\n";
    if ($methods->isNotEmpty()) {
        $first = $methods->first();
        echo "  Example method_id: {$first->audit_method_id}, sample: {$first->sample}\n";
    }
    echo "\n";
}
