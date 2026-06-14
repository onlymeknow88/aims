<?php

namespace Modules\KO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipType;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KO\Entities\KoBrand;
use Modules\KO\Entities\KoUnit;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoAttachment;
use Modules\KO\Entities\KoCommissioning;
use Modules\KO\Entities\KoCommissioningHeader;
use Modules\KO\Entities\KoCommissioningField;
use Modules\KO\Entities\KoCommissioningItem;

class KODummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Run dependencies if needed
        $this->call(PermissionTableSeeder::class);

        // Ensure SpipSeeder is executed if database is empty of SPIP categories
        if (KoSpipCategory::count() === 0) {
            $this->call(SpipSeeder::class);
        }

        // 2. Fetch or create Company
        $company = Company::where('id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')->first();
        if (!$company) {
            $company = Company::first();
        }
        if (!$company) {
            $company = Company::create([
                'id' => 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e',
                'company_name' => 'PT Maruwai Coal',
                'type' => CompanyType::Internal()->value ?? 'Internal',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Fetch or create Department
        $department = Department::where('company_id', $company->id)->first();
        if (!$department) {
            $department = Department::create([
                'id' => 'a1f07935-ad83-4169-98da-d10cc36552eb',
                'name' => 'IT',
                'code' => 'IT',
                'company_id' => $company->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Create / Update Dummy Users for KO Roles
        // A. Maker (Owner Unit)
        $makerUser = User::where('email', 'ko.maker@alamtri.com')->first();
        if (!$makerUser) {
            $makerUser = User::create([
                'id' => (string) Str::uuid(),
                'name' => 'KO Maker (Owner Unit)',
                'email' => 'ko.maker@alamtri.com',
                'password' => Hash::make('password'),
                'department_id' => $department->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $makerUser->update(['department_id' => $department->id]);
        }
        $makerUser->departments()->syncWithoutDetaching([$department->id]);

        // B. Verificator / Inspector (Admin Verification)
        $adminUser = User::where('email', 'ko.admin@alamtri.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'id' => (string) Str::uuid(),
                'name' => 'KO Admin (Safety Inspector)',
                'email' => 'ko.admin@alamtri.com',
                'password' => Hash::make('password'),
                'department_id' => $department->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $adminUser->update(['department_id' => $department->id]);
        }
        $adminUser->departments()->syncWithoutDetaching([$department->id]);

        // C. Coordinator / Approver (Coordinator Verification)
        $coordinatorUser = User::where('email', 'ko.coordinator@alamtri.com')->first();
        if (!$coordinatorUser) {
            $coordinatorUser = User::create([
                'id' => (string) Str::uuid(),
                'name' => 'KO Coordinator (PJO)',
                'email' => 'ko.coordinator@alamtri.com',
                'password' => Hash::make('password'),
                'department_id' => $department->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $coordinatorUser->update(['department_id' => $department->id]);
        }
        $coordinatorUser->departments()->syncWithoutDetaching([$department->id]);

        // 5. Create / Update Spatie Roles & Permissions under 'ko' guard
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $makerRole = Role::firstOrCreate(['name' => 'Keselamatan Operasional - Maker', 'guard_name' => 'ko']);
        $makerRole->syncPermissions([
            'KO - Login',
            'KO - Create Proposal',
            'KO - Request Temporary QR',
            'KO - Print Temporary QR',
            'KO - Print QR',
            'KO - Open PICA',
        ]);

        $verifierRole = Role::firstOrCreate(['name' => 'Keselamatan Operasional - Verificator', 'guard_name' => 'ko']);
        $verifierRole->syncPermissions([
            'KO - Login',
            'KO - Admin Revoke Unit Verification',
            'KO - Admin Proposal Verification',
            'KO - Create Commissioning',
            'KO - Admin Commissioning Verification',
            'KO - Print Temporary QR',
            'KO - Print QR',
            'KO - Open PICA',
            'KO - Admin PICA',
        ]);

        $coordRole = Role::firstOrCreate(['name' => 'Keselamatan Operasional - Koordinator KO', 'guard_name' => 'ko']);
        $coordRole->syncPermissions([
            'KO - Login',
            'KO - Coordinator Revoke Unit Verification',
            'KO - Coordinator Proposal Verification',
            'KO - Coordinator Commissioning Verification',
            'KO - QR Request Verification',
            'KO - Print Temporary QR',
            'KO - Print QR',
            'KO - Coordinator PICA',
            'KO - Solved PICA',
        ]);

        // Direct DB insertion to assign roles to users to bypass potential guard mismatch exceptions in CLI
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => $makerRole->id, 'model_type' => User::class, 'model_id' => $makerUser->id]
        );
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => $verifierRole->id, 'model_type' => User::class, 'model_id' => $adminUser->id]
        );
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => $coordRole->id, 'model_type' => User::class, 'model_id' => $coordinatorUser->id]
        );

        $fadjriUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        if ($fadjriUser) {
            DB::table('model_has_roles')->updateOrInsert(
                ['role_id' => $makerRole->id, 'model_type' => User::class, 'model_id' => $fadjriUser->id]
            );
        }

        $this->command->info('✓ Created dummy users and assigned Spatie KO roles successfully.');

        // 6. Fetch SPIP entities to associate with units
        $spipCategory = KoSpipCategory::first();
        $spipType = KoSpipType::first();
        $spipUnit = KoSpipUnit::first();

        // Ensure we have at least one brand
        $brand = KoBrand::first();
        if (!$brand && $spipCategory) {
            $brand = KoBrand::create([
                'id' => (string) Str::uuid(),
                'ko_spip_category_id' => $spipCategory->id,
                'name' => 'Toyota',
            ]);
        }

        if (!$spipUnit || !$brand) {
            $this->command->error('Error: Spip unit or brand could not be found or seeded.');
            return;
        }

        // 7. Seed Proposal Test Scenarios
        $scenarios = [
            [
                'status' => KoStatus::Draft,
                'call_sign' => 'CS-KO-DRAFT-01',
                'identity' => 'B 1111 DRAFT',
                'number' => 'KO/2026/0001',
                'verified' => false,
            ],
            [
                'status' => KoStatus::AdminProposalVerification,
                'call_sign' => 'CS-KO-WADMIN-02',
                'identity' => 'B 2222 WADMIN',
                'number' => 'KO/2026/0002',
                'verified' => false,
            ],
            [
                'status' => KoStatus::Returned,
                'call_sign' => 'CS-KO-RETURN-03',
                'identity' => 'B 3333 RETURN',
                'number' => 'KO/2026/0003',
                'verified' => false,
                'proposal_reject_note' => 'Dokumen STNK buram, mohon unggah ulang foto yang jelas.',
            ],
            [
                'status' => KoStatus::CoordinatorProposalVerification,
                'call_sign' => 'CS-KO-WCOORD-04',
                'identity' => 'B 4444 WCOORD',
                'number' => 'KO/2026/0004',
                'verified' => true,
            ],
            [
                'status' => KoStatus::Commissioning,
                'call_sign' => 'CS-KO-INCOMM-05',
                'identity' => 'B 5555 INCOMM',
                'number' => 'KO/2026/0005',
                'verified' => true,
            ],
            [
                'status' => KoStatus::CommissioningReturned,
                'call_sign' => 'CS-KO-COMMRET-06',
                'identity' => 'B 6666 COMMRET',
                'number' => 'KO/2026/0006',
                'verified' => true,
                'commissioning_reject_note' => 'Rem tangan tidak berfungsi dengan baik, ganti kampas rem.',
            ],
            [
                'status' => KoStatus::Completed,
                'call_sign' => 'CS-KO-COMPLETED-07',
                'identity' => 'B 7777 COMP',
                'number' => 'KO/2026/0007',
                'verified' => true,
            ],
        ];

        // Truncate existing test unit and proposal data to prevent duplicate keys
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        KoAttachment::truncate();
        KoProposal::where('number', 'like', 'KO/2026/%')->delete();
        KoUnit::where('call_sign', 'like', 'CS-KO-%')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($scenarios as $idx => $sc) {
            // Create Unit
            $unit = KoUnit::create([
                'id' => (string) Str::uuid(),
                'ko_spip_unit_id' => $spipUnit->id,
                'call_sign' => $sc['call_sign'],
                'identity_number' => $sc['identity'],
                'ko_brand_id' => $brand->id,
                'serial_number' => 'SN-TEST-' . (10000 + $idx),
                'model_unit' => 'Hilux Double Cabin 4x4',
                'production_year' => 2023,
                'commissioning_count' => ($sc['status'] === KoStatus::Completed) ? 1 : 0,
                'is_revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Proposal
            $proposal = KoProposal::create([
                'id' => (string) Str::uuid(),
                'number' => $sc['number'],
                'ccow_id' => $company->id,
                'company_id' => $company->id,
                'department_id' => $department->id,
                'area' => 'Lampunut',
                'ko_unit_id' => $unit->id,
                'applicant_email' => 'ko.maker@alamtri.com',
                'pjo_id' => $coordinatorUser->id,
                'internal_komisioning_schedule' => now()->addDays(5)->format('Y-m-d'),
                'next_commissioning' => now()->addYear()->format('Y-m-d'),
                'temporary_validity_period' => now()->addMonths(3)->format('Y-m-d'),
                'commissioning_period' => 1,
                'status' => $sc['status'],
                'admin_proposal_verified' => $sc['verified'],
                'proposal_reject_note' => $sc['proposal_reject_note'] ?? null,
                'commissioning_reject_note' => $sc['commissioning_reject_note'] ?? null,
                'temporary_qr_status' => ($sc['status'] === KoStatus::Completed) ? 'Approved' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Seed Attachment for non-Draft status
            if ($sc['status'] !== KoStatus::Draft) {
                KoAttachment::create([
                    'id' => (string) Str::uuid(),
                    'ko_proposal_id' => $proposal->id,
                    'stnk' => 'uploads/attachments/dummy_stnk.pdf',
                    'nota_pajak' => 'uploads/attachments/dummy_pajak.pdf',
                    'surat_pengantar' => 'uploads/attachments/dummy_pengantar.pdf',
                    're_manufacture' => 'uploads/attachments/dummy_re_manufacture.pdf',
                    'oem' => 'uploads/attachments/dummy_oem.pdf',
                    'dokumen_sertifikat' => 'uploads/attachments/dummy_sertifikat.pdf',
                    'inspeksi_p3k' => 'uploads/attachments/dummy_p3k.pdf',
                    'kir' => 'uploads/attachments/dummy_kir.pdf',
                    'uji_pjit' => 'uploads/attachments/dummy_pjit.pdf',
                    'pra_komisioning' => 'uploads/attachments/dummy_pra_commissioning.pdf',
                    'setting_radio' => 'uploads/attachments/dummy_radio.pdf',
                    'slo' => 'uploads/attachments/dummy_slo.pdf',
                    'komisioning_internal' => 'uploads/attachments/dummy_internal_comm.pdf',
                    'com' => 'uploads/attachments/dummy_com.pdf',
                ]);
            }

            // Seed Commissioning details if in commissioning phase
            if ($sc['status'] === KoStatus::Completed || $sc['status'] === KoStatus::CommissioningReturned) {
                $commissioning = KoCommissioning::create([
                    'id' => (string) Str::uuid(),
                    'ko_proposal_id' => $proposal->id,
                    'date' => now()->format('Y-m-d'),
                    'commissioning_completion_date' => now()->format('Y-m-d'),
                    'smu_odo_meter' => '15430',
                    'engine_status' => 'Re-comm',
                    'expired_date' => now()->addYear()->format('Y-m-d'),
                    'status' => 'Lulus',
                    'created_by' => 'KO Admin (Safety Inspector)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create dummy commissioning item values
                $fields = KoCommissioningField::limit(5)->get();
                foreach ($fields as $f) {
                    KoCommissioningItem::create([
                        'id' => (string) Str::uuid(),
                        'ko_commissioning_id' => $commissioning->id,
                        'ko_commissioning_field_id' => $f->id,
                        'condition' => 'Baik',
                        'note' => 'Checked OK',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $this->command->info("✓ Seeded Proposal Scenario: {$sc['number']} - Status: {$sc['status']}");
        }
    }
}
