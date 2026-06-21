<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$reports = DB::table('audit_implementation_report_modules')->get();
foreach ($reports as $r) {
    $audit = DB::table('audits')->where('id', $r->audit_id)->first();
    echo "Report ID: {$r->id}, Audit ID: {$r->audit_id}, Audit Category: " . ($audit ? $audit->audit_category : 'UNKNOWN') . "\n";
}
