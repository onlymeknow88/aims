<?php

require 'c:/laragon/www/aims/vendor/autoload.php';
$app = require 'c:/laragon/www/aims/bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;
$app->make(Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// 1. Get a user
$user = DB::table('users')->first();
if (!$user) {
    echo "No users found in database.\n";
    exit(1);
}

// 2. Get a department and its code
$department = DB::table('departments')->first();
if (!$department) {
    echo "No departments found in database.\n";
    exit(1);
}
$deptCode = DB::table('department_codes')->where('department_id', $department->id)->first();
$department_code_id = $deptCode ? $deptCode->id : null;

// Get an area manager
$areaManager = DB::table('area_managers')->first();
$area_manager_id = $areaManager ? $areaManager->id : 'a1f685e3-e386-4f54-8dba-2181866dac8b';

// 3. Find or create module, category, and mapping to satisfy relations
$module = DB::table('document_system_modules')->first();
if (!$module) {
    $moduleId = (string) Str::uuid();
    DB::table('document_system_modules')->insert([
        'id' => $moduleId,
        'index' => 'SO',
        'name' => 'Safety Operations',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $module = DB::table('document_system_modules')->where('id', $moduleId)->first();
}

$category = DB::table('document_system_categories')->first();
if (!$category) {
    $categoryId = (string) Str::uuid();
    DB::table('document_system_categories')->insert([
        'id' => $categoryId,
        'module_id' => $module->id,
        'index' => 'SOP-K3',
        'name' => 'SOP K3',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $category = DB::table('document_system_categories')->where('id', $categoryId)->first();
}

$mapping = DB::table('document_system_mappings')->first();
if (!$mapping) {
    $mappingId = (string) Str::uuid();
    DB::table('document_system_mappings')->insert([
        'id' => $mappingId,
        'category_id' => $category->id,
        'index' => 'SOP-WAH',
        'name' => 'SOP Working at Heights',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $mapping = DB::table('document_system_mappings')->where('id', $mappingId)->first();
}

echo "=== MEMULAI SIMULASI DUMMY INPUT ===\n";
echo "Menggunakan User: {$user->email}\n";
echo "Menggunakan Departemen: {$department->name}\n";
echo "Menggunakan Mapping ID: {$mapping->id}\n\n";

DB::beginTransaction();

try {
    // A. Simulasi Dokumen Standar (SOP)
    $sopId = (string) Str::uuid();
    DB::table('document_system_documents')->insert([
        'id' => $sopId,
        'department_id' => $department->id,
        'department_code_id' => $department_code_id,
        'mapping_id' => $mapping->id,
        'area_manager_id' => $area_manager_id,
        'user_id' => $user->id,
        'upload_type' => 'document',
        'document_level' => '2', // Level 2 - SOP
        'status' => '5', // ACTIVE
        'revision' => '0',
        'title' => 'Prosedur Bekerja Aman di Ketinggian (Working at Heights Procedure)',
        'description' => 'Prosedur standar mengenai penggunaan safety harness, penentuan angkur penambat, verifikasi scaffolding, serta mitigasi risiko jatuh dari ketinggian.',
        'sop_number' => '002',
        'document_number' => 'PAMA-OHS-SOP-002',
        'file_path' => 'uploads/documents/SOP-Working-At-Heights.pdf',
        'doc_created' => '2026-06-12',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "✓ Berhasil mensimulasikan Dokumen Standar (SOP):\n";
    echo "  - ID: {$sopId}\n";
    echo "  - Judul: Prosedur Bekerja Aman di Ketinggian\n";
    echo "  - Nomor Dokumen: PAMA-OHS-SOP-002\n";
    echo "  - Status: ACTIVE\n\n";

    // B. Simulasi Job Safety Analysis (JSA)
    $jsaId = (string) Str::uuid();
    DB::table('jsa_documents')->insert([
        'id' => $jsaId,
        'department_id' => $department->id,
        'department_code_id' => $department_code_id,
        'user_id' => $user->id,
        'status' => 1, // ACTIVE
        'title' => 'Pengelasan Konstruksi Tangki Air (Hot Work)',
        'description' => 'Pengelasan tangki air menggunakan mesin las listrik di area workshop. APD: Tameng las, sarung tangan kulit, APAR ready.',
        'document_number' => 'JSA-2026-OHS-004',
        'doc_created' => '2026-06-12 08:00:00',
        'detail_location' => 'Workshop Plant Main Building, Sektor 4B',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    echo "✓ Berhasil mensimulasikan JSA:\n";
    echo "  - ID: {$jsaId}\n";
    echo "  - Judul Pekerjaan: Pengelasan Konstruksi Tangki Air (Hot Work)\n";
    echo "  - Nomor JSA: JSA-2026-OHS-004\n";
    echo "  - Lokasi: Workshop Plant Main Building, Sektor 4B\n";
    echo "  - Status: ACTIVE\n\n";

    // C. Simulasi Permit to Work (PTW)
    $ptwId = (string) Str::uuid();
    DB::table('ptw_documents')->insert([
        'id' => $ptwId,
        'department_id' => $department->id,
        'user_id' => $user->id,
        'status' => 1, // ACTIVE
        'title' => 'Hot Work Permit (Izin Kerja Panas) - Pengelasan Tangki Solar',
        'description' => 'Pekerjaan panas pengelasan tangki solar oleh kontraktor PT. Rekayasa Industri Utama.',
        'document_number' => 'PTW-2026-06-12-001',
        'doc_created' => '2026-06-12 08:00:00',
        'detail_location' => 'Fasilitas Fuel Station Utama, Sektor A-3',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    echo "✓ Berhasil mensimulasikan PTW:\n";
    echo "  - ID: {$ptwId}\n";
    echo "  - Judul Izin: Hot Work Permit (Izin Kerja Panas)\n";
    echo "  - Nomor PTW: PTW-2026-06-12-001\n";
    echo "  - Status: ACTIVE\n\n";

    echo "=== SIMULASI BERHASIL DAN BERSIH (TRANSAKSI DI-ROLLBACK) ===\n";
} catch (\Exception $e) {
    echo "❌ Terjadi error saat simulasi: " . $e->getMessage() . "\n";
} finally {
    DB::rollBack();
    echo "Database transaction rolled back successfully. Database remains clean.\n";
}
