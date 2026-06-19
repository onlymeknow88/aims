<?php

namespace Modules\FieldLeadership\Database\Seeders;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\Pica\PicaStatus;
use App\Enums\PicaSource;
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
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\Pica\Entities\Pica;
use Modules\Pica\Entities\PicaDocument;

class FieldLeadershipPicaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== Seeding Field Leadership linked to PICA ===');

        // 1. Resolve Users & Lookups
        $makerUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        $reviewerUser = User::where('email', 'zakaria.anoi@alamtri.com')->first();
        $approverUser = User::where('email', 'rahmad.siregar@alamtri.com')->first();

        if (!$makerUser || !$reviewerUser || !$approverUser) {
            $this->command->error('Missing required users for Field Leadership workflow seeding.');
            return;
        }

        $company = Company::find('a1f078e5-ed47-4e84-b3c1-9f659cc93a4e'); // PT Maruwai Coal
        $department = Department::find('a1f07935-ad83-4169-98da-d10cc36552eb'); // IT
        $section = Section::find('a1f0862e-4909-4c80-8884-eed6e8c0ce38'); // IT
        $location = AreaLocation::find('a1f685cb-e900-43c0-9992-1bc10bbdcabe'); // Tower
        $pja = AreaManager::find('a1f685e3-e386-4f54-8dba-2181866dac8b'); // Zakaria Anoi (IT)

        $categoryKta = FieldLeadershipCategory::where('name', 'Kondisi Tidak Aman')->first();
        $typeKta = FieldLeadershipKtaAndTta::where('type', 'KTA')->first();
        $potencyHigh = FieldLeadershipPotencyAndConsequnce::where('code', 'H')->first();

        // 2. Clear old seeded dummy data (both FL and Pica links)
        $flId = 'f1a00009-beef-4000-8000-000000000009';
        $picaDocId = 'f1a00009-beef-4000-9000-000000000009';
        $picaPivotId = 'f1a00009-beef-4000-9000-00000000000f';

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FieldLeadershipActivity::where('fl_id', $flId)->delete();
        FieldLeadershipRisk::where('fl_id', $flId)->delete();
        FieldLeadershipMember::where('fl_id', $flId)->delete();
        FieldLeadership::where('id', $flId)->delete();
        
        Pica::where('id', $picaPivotId)->delete();
        PicaDocument::where('id', $picaDocId)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Create Field Leadership Document (Status: Close/Approved)
        $fl = FieldLeadership::create([
            'id' => $flId,
            'number' => 'FL-MAC-PICA-INTEGRATE-DUMMY',
            'date' => Carbon::now()->toDateString(),
            'ccow_id' => $company->id,
            'company_id' => $company->id,
            'detail_company' => CompanyType::Internal,
            'department_id' => $department->id,
            'section_id' => $section->id,
            'area_location_id' => $location->id,
            'detail_location' => 'Lantai 2 Ruang Server Utama',
            'personil_on_review' => 1,
            'personil_on_review_name' => $makerUser->name,
            'pja_id' => $pja->id,
            'type' => 'Regular',
            'job' => 'Pemeriksaan Suhu & Kebersihan Server Room',
            'status' => FieldLeadershipType::Close,
            'published' => 'Publish',
            'requested' => FieldLeadershipType::Approved,
            'created_by' => $makerUser->employee->id,
        ]);

        FieldLeadershipMember::create([
            'fl_id' => $fl->id,
            'type' => CompanyType::Internal,
            'employee_id' => $makerUser->employee->id,
        ]);

        // 4. Create Field Leadership Risk Finding
        $risk = FieldLeadershipRisk::create([
            'fl_id' => $fl->id,
            'risk_condition' => 'Filter AC berdebu tebal berisiko overheat pada server.',
            'category_id' => $categoryKta->id,
            'type_id' => $typeKta->id,
            'potency_id' => $potencyHigh->id,
            'repair_action' => 'Melakukan pembersihan filter AC server room.',
            'due_date' => Carbon::now()->addDays(3)->toDateString(),
            'type_action' => 'Administrasi',
            'supervisor' => 'Supervisor Maintenance IT',
            'status' => FieldLeadershipType::Close,
        ]);

        // 5. Create PICA Document (Corrective Action)
        $picaDoc = PicaDocument::create([
            'id' => $picaDocId,
            'identity_id' => 'FL' . Carbon::now()->format('mY') . '-FL999999',
            'source' => PicaSource::FieldLeadership,
            'type' => 'Regular',
            'date' => Carbon::now()->toDateString(),
            'ccow_id' => $company->id,
            'company_id' => $company->id,
            'section_id' => $section->id,
            'location_id' => $location->id,
            'location_detail' => 'Lantai 2 Ruang Server Utama',
            'company_detail' => CompanyType::Internal,
            'pja_id' => $pja->id,
            'auditor' => $makerUser->name,
            'non_compliance' => 'Filter AC Server Room tertimbun debu tebal.',
            'non_compliance_root_cause' => 'Jadwal pembersihan berkala tidak berjalan rutin.',
            'corrective_action' => 'Melakukan pembersihan filter AC server room.',
            'target_settlement_date' => Carbon::now()->addDays(3)->toDateString(),
            'settlement_date' => Carbon::now()->addDays(3)->toDateString(),
            'requested' => PicaStatus::NewRequest,
            'published' => PicaStatus::Publish,
            'status' => PicaStatus::OnReviewPja, // Awaiting PJA action
        ]);

        // Update the risk with pica_id if the column actually existed (but since it failed, we will skip it or let Laravel handle it if it behaves as a virtual key. However, since the database table lacks the column, we will not set it).
        // The morph pivot (Pica) is the true relation connector:
        Pica::create([
            'id' => $picaPivotId,
            'source' => PicaSource::FieldLeadership,
            'source_id' => $risk->id,
            'picaable_id' => $picaDoc->id,
            'picaable_type' => PicaDocument::class,
        ]);

        // 7. Add Activity Logs for both FL & PICA
        FieldLeadershipActivity::create([
            'fl_id' => $fl->id,
            'description' => 'Document submitted, reviewed, and approved by KTT. Follow-up PICA generated.',
            'user_id' => $approverUser->id,
        ]);

        $picaDoc->activities()->create([
            'description' => 'New Request generated from Field Leadership ' . $fl->number,
            'user_id' => $approverUser->id,
        ]);

        $this->command->info('✓ Seeded Dummy FL: FL-MAC-PICA-INTEGRATE-DUMMY');
        $this->command->info('✓ Seeded Dummy PICA: ' . $picaDoc->identity_id);
    }
}
