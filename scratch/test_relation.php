<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Audit\Entities\Audit;

$audit = Audit::where('audit_category', 'ISO45001')->first();
if ($audit) {
    echo "Audit ID: {$audit->id}\n";
    echo "Audit Number: {$audit->audit_number}\n";
    echo "Category: {$audit->audit_category}\n";
    $report = $audit->implementation_report;
    echo "Report is: " . ($report ? "Found (ID: {$report->id})" : "NULL") . "\n";
    
    // Direct query
    $directReport = \Modules\Audit\Entities\AuditImplementationReportModule::where('audit_id', $audit->id)->first();
    echo "Direct query Report is: " . ($directReport ? "Found (ID: {$directReport->id})" : "NULL") . "\n";
} else {
    echo "Audit not found!\n";
}
