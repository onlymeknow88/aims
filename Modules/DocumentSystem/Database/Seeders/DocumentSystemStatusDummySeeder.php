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

class DocumentSystemStatusDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds several example Documents across all status types:
     * - DRAFT (2)
     * - WAITING REVIEW (1)
     * - ROOTING REVIEW (3)
     * - ON REVISION (4)
     * - OBSOLATE (8)
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('=== Seeding Multi-Status Document Dummies ===');

        // ─────────────────────────────────────────────
        // 1. Resolve User
        // ─────────────────────────────────────────────
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

        // ─────────────────────────────────────────────
        // 2. Resolve Department
        // ─────────────────────────────────────────────
        $department = Department::where('name', 'IT')
            ->where('company_id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')
            ->first();
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

        $area_manager_id = 'a1f685e3-e386-4f54-8dba-2181866dac8b';

        // ─────────────────────────────────────────────
        // 3. Resolve Module / Category / Mapping
        // ─────────────────────────────────────────────
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

        // ─────────────────────────────────────────────
        // 4. Define base payload (shared fields)
        // ─────────────────────────────────────────────
        $base = [
            'department_id'      => $department->id,
            'department_code_id' => $department_code_id,
            'mapping_id'         => $mapping->id,
            'area_manager_id'    => $area_manager_id,
            'user_id'            => $user->id,
            'created_by'         => $user->id, // Required by Draft/OnGoing query filter
            'upload_type'        => 'document',
            'revision'           => '0',
            'is_obsolate'        => 0,
            'doc_created'        => now()->toDateString(),
        ];

        // ─────────────────────────────────────────────
        // 5. Seed DRAFT documents (status = 2)
        // ─────────────────────────────────────────────
        $drafts = [
            [
                'title'           => 'Prosedur Manajemen Risiko K3 – Evaluasi Bahaya Kimia',
                'description'     => 'Dokumen draft awal untuk prosedur identifikasi, penilaian, dan pengendalian risiko bahan kimia berbahaya di area penyimpanan.',
                'document_number' => 'MAC-IT-010',
                'sop_number'      => '010',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
            ],
            [
                'title'           => 'Prosedur Ijin Kerja Ruang Terbatas (Confined Space Entry)',
                'description'     => 'Dokumen draft prosedur untuk semua aktivitas memasuki ruang terbatas, mencakup pre-entry checklist, gas test, rescue plan.',
                'document_number' => 'MAC-IT-011',
                'sop_number'      => '011',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
            ],
            [
                'title'           => 'Manual Pengoperasian Alat Berat – Excavator PC400',
                'description'     => 'Dokumen draft manual operasional excavator PC400 di area tambang terbuka, mencakup pre-operasional check, prosedur pengoperasian, dan shut-down.',
                'document_number' => 'MAC-Manual-005',
                'document_level'  => Document::MN_DOC_TYPE,
                'prefix_code'     => 'MAC-Manual-',
            ],
        ];

        foreach ($drafts as $draft) {
            Document::create(array_merge($base, $draft, [
                'id'     => (string) Str::uuid(),
                'status' => Document::DRAFT, // 2
            ]));
            $this->command->info("  ✓ [DRAFT]          {$draft['document_number']} – {$draft['title']}");
        }

        // ─────────────────────────────────────────────
        // 6. Seed WAITING REVIEW documents (status = 1)
        // ─────────────────────────────────────────────
        $waitingReviews = [
            [
                'title'           => 'Prosedur Pemakaian APD di Area Pengeboran',
                'description'     => 'Dokumen yang menunggu review level 1 (Supervisor) mengenai standar penggunaan APD wajib di area pengeboran aktif.',
                'document_number' => 'MAC-IT-020',
                'sop_number'      => '020',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
            ],
            [
                'title'           => 'Prosedur Penanganan Tumpahan Bahan Bakar (Oil Spill)',
                'description'     => 'SOP respons darurat tumpahan bahan bakar, mencakup containment, notifikasi, pembersihan, dan dokumentasi insiden.',
                'document_number' => 'MAC-IT-021',
                'sop_number'      => '021',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
            ],
        ];

        foreach ($waitingReviews as $doc) {
            Document::create(array_merge($base, $doc, [
                'id'     => (string) Str::uuid(),
                'status' => Document::WAITNG_REVIEW, // 1
            ]));
            $this->command->info("  ✓ [WAITING REVIEW] {$doc['document_number']} – {$doc['title']}");
        }

        // ─────────────────────────────────────────────
        // 7. Seed ROOTING REVIEW documents (status = 3)
        // ─────────────────────────────────────────────
        $rootingReviews = [
            [
                'title'           => 'Prosedur Inspeksi Scaffolding dan Perancah',
                'description'     => 'Dokumen yang sedang direview oleh management level 2 mengenai prosedur inspeksi mingguan scaffolding, tagging system, dan kapasitas beban.',
                'document_number' => 'MAC-IT-030',
                'sop_number'      => '030',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
            ],
        ];

        foreach ($rootingReviews as $doc) {
            Document::create(array_merge($base, $doc, [
                'id'     => (string) Str::uuid(),
                'status' => Document::ROOTING_REVIEW, // 3
            ]));
            $this->command->info("  ✓ [ROOTING REVIEW] {$doc['document_number']} – {$doc['title']}");
        }

        // ─────────────────────────────────────────────
        // 8. Seed ON REVISION documents (status = 4)
        // ─────────────────────────────────────────────
        $onRevisions = [
            [
                'title'           => 'Prosedur Bekerja di Ketinggian – Revisi Perubahan Standar OHSAS',
                'description'     => 'Dokumen dikembalikan untuk revisi: perlu pembaruan referensi standar dari OHSAS 18001 ke ISO 45001 dan penambahan section prosedur rescue.',
                'document_number' => 'MAC-IT-040',
                'sop_number'      => '040',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
                'revision'        => '1',
            ],
            [
                'title'           => 'Instruksi Kerja Lock Out Tag Out (LOTO)',
                'description'     => 'Dokumen dikembalikan untuk revisi: reviewer meminta penambahan diagram visual step-by-step dan daftar equipment yang wajib LOTO.',
                'document_number' => 'WIN-MAC-IT-015',
                'sop_number'      => '040',
                'sop_add_win'     => '015',
                'document_level'  => Document::WIN_DOC_TYPE,
                'prefix_code'     => 'WIN-MAC-IT-',
                'revision'        => '1',
            ],
        ];

        foreach ($onRevisions as $doc) {
            Document::create(array_merge($base, $doc, [
                'id'     => (string) Str::uuid(),
                'status' => Document::ON_REVISION, // 4
            ]));
            $this->command->info("  ✓ [ON REVISION]    {$doc['document_number']} – {$doc['title']}");
        }

        // ─────────────────────────────────────────────
        // 9. Seed OBSOLETE documents (status = 8)
        // ─────────────────────────────────────────────
        $obsoletes = [
            [
                'title'           => 'Prosedur K3 Lama – Penggunaan Peralatan Las (Versi 2019)',
                'description'     => 'Dokumen prosedur pengelasan yang telah digantikan oleh versi 2024. Dinyatakan obsolete setelah pengesahan dokumen revisi baru.',
                'document_number' => 'MAC-IT-001',
                'sop_number'      => '001',
                'document_level'  => Document::SOP_DOC_TYPE,
                'prefix_code'     => 'MAC-IT-',
                'revision'        => '3',
                'is_obsolate'     => 1,
            ],
            [
                'title'           => 'Manual Keselamatan Umum Site – Edisi 2020',
                'description'     => 'Dokumen panduan keselamatan umum di area tambang yang telah digantikan oleh edisi 2025 yang mencakup protokol COVID-19 dan pembaruan regulasi.',
                'document_number' => 'MAC-Manual-002',
                'document_level'  => Document::MN_DOC_TYPE,
                'prefix_code'     => 'MAC-Manual-',
                'revision'        => '2',
                'is_obsolate'     => 1,
            ],
        ];

        foreach ($obsoletes as $doc) {
            Document::create(array_merge($base, $doc, [
                'id'     => (string) Str::uuid(),
                'status' => Document::OBSOLATE, // 8
            ]));
            $this->command->info("  ✓ [OBSOLETE]       {$doc['document_number']} – {$doc['title']}");
        }

        $this->command->newLine();
        $this->command->info('=== Done. ' . (count($drafts) + count($waitingReviews) + count($rootingReviews) + count($onRevisions) + count($obsoletes)) . ' multi-status documents seeded. ===');
    }
}
