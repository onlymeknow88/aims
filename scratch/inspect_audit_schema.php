<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = [
    'audits',
    'audit_smkps',
    'audit_teams',
    'audit_smkp_teams',
    'companies',
    'departments'
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
