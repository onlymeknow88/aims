<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('audit_implementation_report_modules')) {
    print_r(Schema::getColumnListing('audit_implementation_report_modules'));
} else {
    echo "Not found!\n";
}
