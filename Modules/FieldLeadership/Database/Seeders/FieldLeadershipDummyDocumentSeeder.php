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
use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;

class FieldLeadershipDummyDocumentSeeder extends Seeder
{
    /**
     * Seed realistic dummy Field Leadership documents with all related data.
     * Requires that master data (categories, parameters, KTA/TTA, potency)
     * and core lookup tables (companies, departments, sections, area_locations,
     * area_managers, employees) already exist.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all document-related tables (leaf to root order)
        FieldLeadershipActivity::truncate();
        FieldLeadershipRisk::truncate();
        FieldLeadershipPositive::truncate();
        FieldLeadershipMember::truncate();
        FieldLeadershipQuestionPto::truncate();
        FieldLeadership::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── Pull lookup data ─────────────────────────────────────────────────
        $ccow        = Company::where('type', CompanyType::Internal)->first();
        $company     = Company::first();
        $department  = Department::where('company_id', optional($ccow)->id)->first()
                        ?? Department::first();
        $section     = Section::where('department_id', optional($department)->id)->first()
                        ?? Section::first();
        $location    = AreaLocation::where('section_id', optional($section)->id)->first()
                        ?? AreaLocation::first();
        $areaManager = AreaManager::where('section_id', optional($section)->id)->first()
                        ?? AreaManager::first();
        $pjoUser     = User::first();
        $employee    = Employee::first();
        $param       = FieldLeadershipParameter::first();

        $categoryKta = FieldLeadershipCategory::where('name', 'Kondisi Tidak Aman')->first();
        $categoryTta = FieldLeadershipCategory::where('name', 'Tindakan Tidak Aman')->first();
        $typeKta     = FieldLeadershipKtaAndTta::where('type', 'KTA')->first();
        $typeTta     = FieldLeadershipKtaAndTta::where('type', 'TTA')->first();
        $potencyHigh = FieldLeadershipPotencyAndConsequnce::where('code', 'H')->first()
                        ?? FieldLeadershipPotencyAndConsequnce::first();
        $potencyMed  = FieldLeadershipPotencyAndConsequnce::where('code', 'M')->first()
                        ?? FieldLeadershipPotencyAndConsequnce::first();

        // Guard: skip if core lookups are missing
        if (!$ccow || !$department || !$section || !$location || !$areaManager || !$pjoUser) {
            $this->command->warn(
                '⚠️  FieldLeadership dummy seeder skipped: required lookup data missing. ' .
                'Please seed companies, departments, sections, area_locations, and area_managers first.'
            );
            return;
        }

        // ─── Document definitions ─────────────────────────────────────────────
        $documents = [
            // 1. Field Leadership Observation – Draft
            [
                'type'      => 'Field Leadership Observation',
                'status'    => FieldLeadershipType::Open,
                'published' => 'Draft',
                'requested' => null,
                'date'      => Carbon::now()->subDays(10)->format('Y-m-d'),
            ],

            // 2. Planned Task Observation – On Review PJA
            [
                'type'      => 'Planned Task Observation',
                'status'    => FieldLeadershipType::OnReviewPja,
                'published' => 'Draft',
                'requested' => FieldLeadershipType::RequestedPja,
                'date'      => Carbon::now()->subDays(7)->format('Y-m-d'),
            ],

            // 3. Hazard Report – On Review Approval
            [
                'type'      => 'Hazard Report',
                'status'    => FieldLeadershipType::OnReviewApproval,
                'published' => 'Draft',
                'requested' => FieldLeadershipType::RequestedApproval,
                'date'      => Carbon::now()->subDays(5)->format('Y-m-d'),
            ],

            // 4. Field Leadership Observation – Closed / Published
            [
                'type'      => 'Field Leadership Observation',
                'status'    => FieldLeadershipType::Close,
                'published' => 'Publish',
                'requested' => FieldLeadershipType::RequestedApproval,
                'date'      => Carbon::now()->subDays(2)->format('Y-m-d'),
            ],
        ];

        foreach ($documents as $index => $doc) {
            $count           = $index + 1;
            $formattedNumber = str_pad($count, 6, '0', STR_PAD_LEFT);
            $dateCode        = Carbon::parse($doc['date'])->format('dmY');
            $docCode         = optional($company)->document_code ?? 'XX';
            $number          = "FL-{$docCode}-{$dateCode}-{$formattedNumber}";

            /** @var FieldLeadership $fl */
            $fl = FieldLeadership::create([
                'number'               => $number,
                'date'                 => $doc['date'],
                'ccow_id'              => $ccow->id,
                'company_id'           => $company->id,
                'detail_company'       => optional($company)->type ?? CompanyType::Internal,
                'department_id'        => $department->id,
                'section_id'           => $section->id,
                'area_location_id'     => $location->id,
                'detail_location'      => 'Area Tambang Blok ' . chr(64 + $count),
                'personil_on_review'   => rand(3, 10),
                'personil_on_review_name' => 'Personel ' . chr(64 + $count),
                'pja_id'               => $areaManager->id,
                'pjo_id'               => $pjoUser->id,
                'type'                 => $doc['type'],
                'job'                  => 'SOP-HSE-00' . $count . ' – Keselamatan Operasi Alat Berat',
                'visit_time'           => rand(15, 60),
                'non_compliance_root'  => 'Kurangnya pengawasan dan sosialisasi prosedur keselamatan.',
                'status'               => $doc['status'],
                'published'            => $doc['published'],
                'requested'            => $doc['requested'],
                'created_by'           => optional($employee)->id ?? null,
            ]);

            // ─── Members ──────────────────────────────────────────────────────
            if ($employee) {
                FieldLeadershipMember::create([
                    'fl_id'       => $fl->id,
                    'type'        => CompanyType::Internal,
                    'employee_id' => $employee->id,
                ]);
            }

            // ─── Positive Conditions ──────────────────────────────────────────
            $positives = [
                'Pekerja memakai APD lengkap sesuai standar.',
                'Kondisi area kerja bersih dan tertata dengan rapi.',
                'Rambu keselamatan terpasang di setiap titik berisiko.',
            ];

            foreach ($positives as $pos) {
                FieldLeadershipPositive::create([
                    'fl_id'       => $fl->id,
                    'description' => $pos,
                ]);
            }

            // ─── Risk Conditions ──────────────────────────────────────────────
            $risks = [
                [
                    'risk_condition' => 'Pekerja tidak menggunakan safety belt saat bekerja di ketinggian.',
                    'category_id'   => optional($categoryTta)->id,
                    'type_id'       => optional($typeTta)->id,
                    'potency_id'    => optional($potencyHigh)->id,
                    'repair_action' => 'Tegur dan beri peringatan tertulis; wajibkan pemakaian safety belt.',
                    'due_date'      => Carbon::now()->addDays(7)->format('Y-m-d'),
                    'type_action'   => 'Administrasi',
                    'supervisor'    => 'Supervisor Keselamatan',
                    'status'        => FieldLeadershipType::Open,
                ],
                [
                    'risk_condition' => 'Terdapat ceceran oli di jalur lalu lintas alat berat.',
                    'category_id'   => optional($categoryKta)->id,
                    'type_id'       => optional($typeKta)->id,
                    'potency_id'    => optional($potencyMed)->id,
                    'repair_action' => 'Bersihkan ceceran oli dan pasang rambu peringatan.',
                    'due_date'      => Carbon::now()->addDays(3)->format('Y-m-d'),
                    'type_action'   => 'Teknik Rekayasa',
                    'supervisor'    => 'Kepala Seksi Operasi',
                    'status'        => FieldLeadershipType::Open,
                ],
            ];

            foreach ($risks as $riskData) {
                FieldLeadershipRisk::create(array_merge($riskData, ['fl_id' => $fl->id]));
            }

            // ─── PTO Questions (only for Planned Task Observation) ────────────
            if ($doc['type'] === 'Planned Task Observation') {
                $questions = [
                    ['question' => 'Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa Anda?',     'answer' => 'Ya',   'description' => 'Risiko utama: terjatuh dari ketinggian.'],
                    ['question' => 'Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?',        'answer' => 'Ya',   'description' => 'Safety net dan safety belt tersedia.'],
                    ['question' => 'Bagaimana Anda mengetahui pengendalian penting tersebut efektif?',            'answer' => '-',    'description' => 'Dilakukan inspeksi harian.'],
                    ['question' => 'Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesesuaian?',       'answer' => 'Ya',   'description' => 'SOP dipatuhi dengan baik.'],
                    ['question' => 'Pekerja memahami SOP/INK/JSA tersebut?',                                      'answer' => 'Ya',   'description' => 'Telah dilakukan safety briefing.'],
                    ['question' => 'Apakah ada opportunity untuk proses SOP/INK/JSA yang lebih efisien?',         'answer' => 'Tidak','description' => 'SOP sudah optimal.'],
                ];

                foreach ($questions as $q) {
                    FieldLeadershipQuestionPto::create([
                        'fl_id'       => $fl->id,
                        'question'    => $q['question'],
                        'answer'      => $q['answer'],
                        'description' => $q['description'],
                    ]);
                }
            }

            // ─── Activity Log ─────────────────────────────────────────────────
            FieldLeadershipActivity::create([
                'fl_id'       => $fl->id,
                'description' => 'Dokumen Field Leadership dibuat oleh seeder.',
                'user_id'     => $pjoUser->id,
            ]);

            $this->command->line("   → Created FL #{$count}: [{$doc['type']}] {$number}");
        }

        $this->command->info('✅  FieldLeadership dummy documents seeded (' . count($documents) . ' records).');
    }
}
