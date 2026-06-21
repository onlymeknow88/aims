<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // 1. Temporarily drop foreign key constraint on csms_checklists if it exists
    try {
        Schema::table('csms_checklists', function (Blueprint $table) {
            $table->dropForeign('csms_checklists_bidding_id_foreign');
        });
        echo "Dropped foreign key constraint csms_checklists_bidding_id_foreign\n";
    } catch (\Exception $e) {
        echo "Foreign key constraint was already dropped or did not exist: " . $e->getMessage() . "\n";
    }

    $migrationsPath = base_path('Modules/CSMS/Database/Migrations');
    $files = glob($migrationsPath . '/*.php');

    // 2. Re-create all tables/columns
    foreach ($files as $file) {
        $filename = basename($file);
        
        // Skip checklists as they were not rolled back
        if (
            str_contains($filename, 'create_csms_csms_master_data_checklist_table') ||
            str_contains($filename, 'create_csms_checklists_table') ||
            str_contains($filename, 'create_csms_checklist_attachments_table') ||
            str_contains($filename, 'alter_csms_master_data_checklist_table_add_ordinal_number') ||
            str_contains($filename, 'alter_csms_checklist_table_add_ordinal_number')
        ) {
            continue;
        }

        echo "Up: " . $filename . "\n";
        $migration = require $file;
        if (is_object($migration) && method_exists($migration, 'up')) {
            $migration->up();
        }
    }

    // 3. Add foreign key constraint back
    try {
        Schema::table('csms_checklists', function (Blueprint $table) {
            $table->foreign('bidding_id')
                ->references('id')
                ->on('biddings')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
        echo "Re-added foreign key constraint csms_checklists_bidding_id_foreign\n";
    } catch (\Exception $e) {
        echo "Error re-adding foreign key constraint: " . $e->getMessage() . "\n";
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "Successfully restored CSMS tables!\n";
});
