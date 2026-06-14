<?php

namespace Modules\FieldLeadership\Database\Seeders;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;

class FieldLeadershipWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== Seeding Field Leadership Workflow Documents ===');

        // 1. Resolve Users & Roles
        $makerUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        $reviewerUser = User::where('email', 'zakaria.anoi@alamtri.com')->first();
        $approverUser = User::where('email', 'rahmad.siregar@alamtri.com')->first();

        if (!$makerUser || !$reviewerUser || !$approverUser) {
            $this->command->error('Missing required users for Field Leadership workflow seeding.');
            return;
        }

        // 2. Resolve Master Lookups
        $company = Company::find('a1f078e5-ed47-4e84-b3c1-9f659cc93a4e'); // PT Maruwai Coal
        $department = Department::find('a1f07935-ad83-4169-98da-d10cc36552eb'); // IT
        $section = Section::find('a1f0862e-4909-4c80-8884-eed6e8c0ce38'); // IT
        $location = AreaLocation::find('a1f685cb-e900-43c0-9992-1bc10bbdcabe'); // Tower
        $pja = AreaManager::find('a1f685e3-e386-4f54-8dba-2181866dac8b'); // Zakaria Anoi (IT)

        $categoryKta = FieldLeadershipCategory::where('name', 'Kondisi Tidak Aman')->first();
        $categoryTta = FieldLeadershipCategory::where('name', 'Tindakan Tidak Aman')->first();
        $typeKta = FieldLeadershipKtaAndTta::where('type', 'KTA')->first();
        $typeTta = FieldLeadershipKtaAndTta::where('type', 'TTA')->first();
        $potencyHigh = FieldLeadershipPotencyAndConsequnce::where('code', 'H')->first();
        $potencyMed = FieldLeadershipPotencyAndConsequnce::where('code', 'M')->first();

        // Ensure Company is linked to Approver
        if ($company->user_id !== $approverUser->id) {
            $company->update(['user_id' => $approverUser->id]);
            $this->command->info("✓ Linked Company {$company->company_name} to KTT/Approver: {$approverUser->email}");
        }

        // Clean up previously seeded workflow test documents
        $testIds = [
            'f1a00001-beef-4000-8000-000000000001',
            'f1a00002-beef-4000-8000-000000000002',
            'f1a00003-beef-4000-8000-000000000003',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FieldLeadershipActivity::whereIn('fl_id', $testIds)->delete();
        FieldLeadershipRisk::whereIn('fl_id', $testIds)->delete();
        FieldLeadershipPositive::whereIn('fl_id', $testIds)->delete();
        FieldLeadershipMember::whereIn('fl_id', $testIds)->delete();
        FieldLeadershipQuestionPto::whereIn('fl_id', $testIds)->delete();
        FieldLeadership::whereIn('id', $testIds)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- Document 1: Maker Submitted, Awaiting Review from PJA (Zakaria) ---
        $fl1 = FieldLeadership::create([
            'id' => 'f1a00001-beef-4000-8000-000000000001',
            'number' => 'FL-MAC-130626-FADJRI-01',
            'date' => Carbon::now()->toDateString(),
            'ccow_id' => $company->id,
            'company_id' => $company->id,
            'detail_company' => CompanyType::Internal,
            'department_id' => $department->id,
            'section_id' => $section->id,
            'area_location_id' => $location->id,
            'detail_location' => 'Lantai 2 Ruang Server Utama',
            'personil_on_review' => 2,
            'personil_on_review_name' => 'Fadjri W & Team IT',
            'pja_id' => $pja->id,
            'pjo_id' => null,
            'type' => 'Regular',
            'job' => 'Pengecekan Kabel dan Suhu Server Room',
            'visit_time' => 30,
            'non_compliance_root' => 'Kabel UTP bergelantungan tanpa conduit rapi.',
            'status' => FieldLeadershipType::Open,
            'published' => 'Publish',
            'requested' => FieldLeadershipType::RequestedPja,
            'created_by' => $makerUser->employee->id,
        ]);

        FieldLeadershipMember::create([
            'fl_id' => $fl1->id,
            'type' => CompanyType::Internal,
            'employee_id' => $makerUser->employee->id,
        ]);

        FieldLeadershipRisk::create([
            'fl_id' => $fl1->id,
            'risk_condition' => 'Kabel UTP yang tidak tertata berpotensi tersandung.',
            'category_id' => $categoryKta->id,
            'type_id' => $typeKta->id,
            'potency_id' => $potencyMed->id,
            'repair_action' => 'Pemasangan pipa conduit dan ducting kabel.',
            'due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'type_action' => 'Teknik Rekayasa',
            'supervisor' => 'Supervisor Infrastruktur IT',
            'status' => FieldLeadershipType::Open,
        ]);

        FieldLeadershipActivity::create([
            'fl_id' => $fl1->id,
            'description' => 'Document submitted by Maker ' . $makerUser->name,
            'user_id' => $makerUser->id,
        ]);

        $this->command->info('✓ [Stage 1: Awaiting PJA] Seeded: FL-MAC-130626-FADJRI-01 (Waiting for Zakaria)');

        // --- Document 2: PJA Reviewed, Awaiting Approval from KTT (Rahmad) ---
        $fl2 = FieldLeadership::create([
            'id' => 'f1a00002-beef-4000-8000-000000000002',
            'number' => 'FL-MAC-130626-FADJRI-02',
            'date' => Carbon::now()->subDays(1)->toDateString(),
            'ccow_id' => $company->id,
            'company_id' => $company->id,
            'detail_company' => CompanyType::Internal,
            'department_id' => $department->id,
            'section_id' => $section->id,
            'area_location_id' => $location->id,
            'detail_location' => 'Area Tower Telekomunikasi',
            'personil_on_review' => 1,
            'personil_on_review_name' => 'Fadjri Wivindi',
            'pja_id' => $pja->id,
            'pjo_id' => null,
            'type' => 'Planned Task Observation',
            'job' => 'Observasi Bekerja di Ketinggian Tower IT',
            'visit_time' => 45,
            'non_compliance_root' => 'Prosedur pemakaian safety harness sudah sesuai, pengaman tambat kuat.',
            'status' => FieldLeadershipType::OnReviewApproval,
            'published' => 'Publish',
            'requested' => FieldLeadershipType::RequestedApproval,
            'created_by' => $makerUser->employee->id,
        ]);

        FieldLeadershipMember::create([
            'fl_id' => $fl2->id,
            'type' => CompanyType::Internal,
            'employee_id' => $makerUser->employee->id,
        ]);

        // PTO Questions
        $questions = [
            ['question' => 'Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa Anda?', 'answer' => 'Ya', 'description' => 'Risiko jatuh dari ketinggian.'],
            ['question' => 'Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?', 'answer' => 'Ya', 'description' => 'Safety harness dan lanyard ganda.'],
            ['question' => 'Bagaimana Anda mengetahui pengendalian penting tersebut efektif?', 'answer' => '-', 'description' => 'Inspeksi pre-use harness dilakukan.'],
            ['question' => 'Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesesuaian?', 'answer' => 'Ya', 'description' => 'SOP WAH dipatuhi.'],
            ['question' => 'Pekerja memahami SOP/INK/JSA tersebut?', 'answer' => 'Ya', 'description' => 'Sudah mendapat training bekerja di ketinggian.'],
            ['question' => 'Apakah ada opportunity untuk proses SOP/INK/JSA yang lebih efisien?', 'answer' => 'Tidak', 'description' => 'Sudah cukup efisien.'],
        ];

        foreach ($questions as $q) {
            FieldLeadershipQuestionPto::create([
                'fl_id' => $fl2->id,
                'question' => $q['question'],
                'answer' => $q['answer'],
                'description' => $q['description'],
            ]);
        }

        FieldLeadershipActivity::create([
            'fl_id' => $fl2->id,
            'description' => 'Document submitted by Maker ' . $makerUser->name,
            'user_id' => $makerUser->id,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        FieldLeadershipActivity::create([
            'fl_id' => $fl2->id,
            'description' => 'Document reviewed and submitted to Approval by Reviewer/PJA ' . $reviewerUser->name,
            'user_id' => $reviewerUser->id,
        ]);

        $this->command->info('✓ [Stage 2: Awaiting Approval] Seeded: FL-MAC-130626-FADJRI-02 (Waiting for Rahmad)');

        // --- Document 3: Approved & Closed by KTT (Rahmad) ---
        $fl3 = FieldLeadership::create([
            'id' => 'f1a00003-beef-4000-8000-000000000003',
            'number' => 'FL-MAC-130626-FADJRI-03',
            'date' => Carbon::now()->subDays(3)->toDateString(),
            'ccow_id' => $company->id,
            'company_id' => $company->id,
            'detail_company' => CompanyType::Internal,
            'department_id' => $department->id,
            'section_id' => $section->id,
            'area_location_id' => $location->id,
            'detail_location' => 'Ruang Server IT Gedung Utama',
            'personil_on_review' => 2,
            'personil_on_review_name' => 'Fadjri Wivindi',
            'pja_id' => $pja->id,
            'pjo_id' => null,
            'type' => 'Regular',
            'job' => 'Inspeksi Kebersihan Filter AC Server Room',
            'visit_time' => 20,
            'non_compliance_root' => 'Debu tebal pada filter AC menghambat sirkulasi udara.',
            'status' => FieldLeadershipType::Close,
            'published' => 'Publish',
            'requested' => FieldLeadershipType::Approved,
            'created_by' => $makerUser->employee->id,
        ]);

        FieldLeadershipMember::create([
            'fl_id' => $fl3->id,
            'type' => CompanyType::Internal,
            'employee_id' => $makerUser->employee->id,
        ]);

        FieldLeadershipRisk::create([
            'fl_id' => $fl3->id,
            'risk_condition' => 'Debu tebal pada filter AC server.',
            'category_id' => $categoryKta->id,
            'type_id' => $typeKta->id,
            'potency_id' => $potencyHigh->id,
            'repair_action' => 'Pembersihan filter AC server secara berkala.',
            'due_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            'type_action' => 'Administrasi',
            'supervisor' => 'Supervisor Maintenance IT',
            'status' => FieldLeadershipType::Close,
        ]);

        FieldLeadershipActivity::create([
            'fl_id' => $fl3->id,
            'description' => 'Document submitted by Maker ' . $makerUser->name,
            'user_id' => $makerUser->id,
            'created_at' => Carbon::now()->subDays(3),
        ]);

        FieldLeadershipActivity::create([
            'fl_id' => $fl3->id,
            'description' => 'Document reviewed and submitted to Approval by Reviewer/PJA ' . $reviewerUser->name,
            'user_id' => $reviewerUser->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        FieldLeadershipActivity::create([
            'fl_id' => $fl3->id,
            'description' => 'Field Leadership Case Closed / Approved by KTT ' . $approverUser->name,
            'user_id' => $approverUser->id,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->command->info('✓ [Stage 3: Approved/Closed] Seeded: FL-MAC-130626-FADJRI-03 (Approved by Rahmad)');
        $this->command->info('=== Seeding Complete ===');
    }
}
