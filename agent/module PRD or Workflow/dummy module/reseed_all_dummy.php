<?php
require 'c:/laragon/www/aims/vendor/autoload.php';
$app = require 'c:/laragon/www/aims/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Hard-delete all dummy docs created by this user (force delete due to SoftDeletes)
$deleted = Illuminate\Support\Facades\DB::table('document_system_documents')
    ->where('user_id', 'a1f079a4-a373-4b19-9fda-d3592f7907d9')
    ->delete();
echo "Deleted {$deleted} dummy documents.\n";

// Re-seed: ACTIVE document first
Illuminate\Support\Facades\Artisan::call('db:seed', [
    '--class' => 'Modules\\DocumentSystem\\Database\\Seeders\\DocumentSystemDummySeederTableSeeder',
    '--force' => true,
]);
echo Illuminate\Support\Facades\Artisan::output();

// Re-seed: multi-status documents
Illuminate\Support\Facades\Artisan::call('db:seed', [
    '--class' => 'Modules\\DocumentSystem\\Database\\Seeders\\DocumentSystemStatusDummySeeder',
    '--force' => true,
]);
echo Illuminate\Support\Facades\Artisan::output();
