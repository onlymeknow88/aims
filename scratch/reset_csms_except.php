<?php

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    $tablesToTruncate = [
        'biddings',
        'csms_memo_ktts',
        'csms_memo_ktt_files',
        'csms_letters',
        'csms_letter_files',
        'csms_dictionaries',
        'csms_pjos',
        'csms_pjo_files',
        'csms_checklist_attachments'
    ];

    foreach ($tablesToTruncate as $table) {
        echo "Truncating table: {$table}\n";
        DB::table($table)->truncate();
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "Done truncating CSMS tables except checklist & master data checklist!\n";
});
