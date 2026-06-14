<?php

namespace Modules\DocumentSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Department;
use Modules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Entities\ModuleCategory;
use Modules\DocumentSystem\Entities\Mapping;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\PtwDocument;

class DocumentSystemDummySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Get or create a User
        $user = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        if (!$user) {
            $user = User::create([
                'id' => 'a1f079a4-a373-4b19-9fda-d3592f7907d9',
                'name' => 'Fadjri Wivindi',
                'email' => 'fadjri.wivindi@alamtri.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Link user to PT Maruwai Coal (a1f078e5-ed47-4e84-b3c1-9f659cc93a4e)
        DB::table('companies')
            ->where('id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')
            ->update(['user_id' => $user->id]);

        // 2. Get or create a Department
        $department = Department::where('name', 'IT')->where('company_id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')->first();
        if (!$department) {
            $department = Department::create([
                'id' => 'a1f07935-ad83-4169-98da-d10cc36552eb',
                'name' => 'IT',
                'code' => 'IT',
                'company_id' => 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ensure user is associated with the department in both column and pivot table
        $user->update(['department_id' => $department->id]);
        $user->departments()->syncWithoutDetaching([$department->id]);

        // Create department_codes entry if it does not exist
        $deptCode = DB::table('department_codes')->where('department_id', $department->id)->first();
        if (!$deptCode) {
            $deptCodeId = (string) Str::uuid();
            DB::table('department_codes')->insert([
                'id' => $deptCodeId,
                'department_id' => $department->id,
                'code' => 'IT',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $department_code_id = $deptCodeId;
        } else {
            $department_code_id = $deptCode->id;
        }

        // Assign Spatie permissions for document-system guard to user
        $permissions = DB::table('permissions')->where('guard_name', 'document-system')->get();
        foreach ($permissions as $permission) {
            DB::table('model_has_permissions')->updateOrInsert([
                'permission_id' => $permission->id,
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);
        }

        // Link area manager to IT department and assign permissions
        $areaManagerUser = User::find('a1f080e2-e013-45fd-9309-de7456f70516');
        if ($areaManagerUser) {
            $areaManagerUser->update(['department_id' => $department->id]);
            $areaManagerUser->departments()->syncWithoutDetaching([$department->id]);
            foreach ($permissions as $permission) {
                DB::table('model_has_permissions')->updateOrInsert([
                    'permission_id' => $permission->id,
                    'model_type' => User::class,
                    'model_id' => $areaManagerUser->id,
                ]);
            }
        }

        // 3. Find or create module, category, and mapping to satisfy relations
        $module = Module::where('name', 'Safety Operations')->first();
        if (!$module) {
            $module = new Module();
            $module->id = (string) Str::uuid();
            $module->index = 'SO';
            $module->name = 'Safety Operations';
            $module->has_document_number = true;
            $module->save();
        }

        $category = ModuleCategory::where('name', 'SOP K3')->where('module_id', $module->id)->first();
        if (!$category) {
            $category = new ModuleCategory();
            $category->id = (string) Str::uuid();
            $category->module_id = $module->id;
            $category->index = 'SOP-K3';
            $category->name = 'SOP K3';
            $category->save();
        }

        $mapping = Mapping::where('name', 'SOP Working at Heights')->where('category_id', $category->id)->first();
        if (!$mapping) {
            $mapping = new Mapping();
            $mapping->id = (string) Str::uuid();
            $mapping->category_id = $category->id;
            $mapping->index = 'SOP-WAH';
            $mapping->name = 'SOP Working at Heights';
            $mapping->save();
        }

        // A. Insert Dokumen Standar (SOP)
        $sop = Document::create([
            'id' => (string) Str::uuid(),
            'department_id' => $department->id,
            'department_code_id' => $department_code_id,
            'mapping_id' => $mapping->id,
            'area_manager_id' => 'a1f685e3-e386-4f54-8dba-2181866dac8b',
            'user_id' => $user->id,
            'created_by' => $user->id,
            'upload_type' => 'document',
            'document_level' => Document::SOP_DOC_TYPE,
            'prefix_code' => 'MAC-IT-',
            'status' => Document::ACTIVE, // ACTIVE
            'revision' => '0',
            'title' => 'Prosedur Bekerja Aman di Ketinggian (Working at Heights Procedure)',
            'description' => 'Prosedur standar mengenai penggunaan safety harness, penentuan angkur penambat, verifikasi scaffolding, serta mitigasi risiko jatuh dari ketinggian.',
            'sop_number' => '002',
            'document_number' => 'MAC-IT-002',
            'file_path' => 'uploads/documents/SOP-Working-At-Heights.pdf',
            'doc_created' => '2026-06-12',
            'is_obsolate' => 0,
        ]);
        
        $this->command->info("✓ Seeded Document: {$sop->document_number} - {$sop->title}");

        // B. Insert Job Safety Analysis (JSA)
        $jsa = JsaDocument::create([
            'id' => (string) Str::uuid(),
            'department_id' => $department->id,
            'department_code_id' => $department_code_id,
            'user_id' => $user->id,
            'status' => 1, // ACTIVE
            'title' => 'Pengelasan Konstruksi Tangki Air (Hot Work)',
            'description' => 'Pengelasan tangki air menggunakan mesin las listrik di area workshop. APD: Tameng las, sarung tangan kulit, APAR ready.',
            'document_number' => 'JSA-2026-OHS-004',
            'doc_created' => '2026-06-12 08:00:00',
            'detail_location' => 'Workshop Plant Main Building, Sektor 4B',
            'is_obsolate' => 0,
        ]);

        $this->command->info("✓ Seeded JSA: {$jsa->document_number} - {$jsa->title}");

        // C. Insert Permit to Work (PTW)
        $ptw = PtwDocument::create([
            'id' => (string) Str::uuid(),
            'department_id' => $department->id,
            'user_id' => $user->id,
            'status' => 1, // ACTIVE
            'title' => 'Hot Work Permit (Izin Kerja Panas) - Pengelasan Tangki Solar',
            'description' => 'Pekerjaan panas pengelasan tangki solar oleh kontraktor PT. Rekayasa Industri Utama.',
            'document_number' => 'PTW-2026-06-12-001',
            'doc_created' => '2026-06-12 08:00:00',
            'detail_location' => 'Fasilitas Fuel Station Utama, Sektor A-3',
        ]);

        $this->command->info("✓ Seeded PTW: {$ptw->document_number} - {$ptw->title}");
    }
}
