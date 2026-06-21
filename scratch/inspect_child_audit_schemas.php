<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = [
    'audit_plans',
    'audit_plan_details',
    'audit_implementation_activities',
    'audit_criteria_modules',
    'audit_notice_letters',
    'audit_opening_attendances',
    'audit_closing_attendances',
    'audit_response_audits',
    'audit_report_results',
    'audit_another_attachments',
    'audit_smkp_notice_letters'
];

foreach ($tables as $t) {
    if (Schema::hasTable($t)) {
        echo "Table: $t\n";
        print_r(Schema::getColumnListing($t));
        echo "\n-----------------------------------\n";
    } else {
        echo "Table: $t (NOT FOUND)\n";
    }
}
