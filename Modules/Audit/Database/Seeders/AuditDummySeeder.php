<?php

namespace Modules\Audit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditTeam;
use Modules\Audit\Entities\AuditTeamRole;
use Modules\Audit\Entities\AuditMasterCriteria;
use Modules\Audit\Entities\AuditMasterAdjustmentFactor;
use Modules\Audit\Entities\AuditMasterEligibility;
use Modules\Audit\Entities\AuditMasterSafetyPerformance;
use Modules\Audit\Enums\AuditCategory;
use Modules\Audit\Enums\AuditType;
use Modules\Audit\Enums\BundleStatusEnum;

class AuditDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Run core dependencies first if empty
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        if (Schema::hasTable('permissions')) {
            $this->call(PermissionTableSeeder::class);
        }
        if (Schema::hasTable('audit_methods') && DB::table('audit_methods')->count() === 0) {
            $this->call(AuditMethodSeederTableSeeder::class);
        }
        if (Schema::hasTable('audit_risk_severities') && DB::table('audit_risk_severities')->count() === 0) {
            $this->call(RiskSeveritySeeder::class);
        }
        if (Schema::hasTable('audit_man_days') && DB::table('audit_man_days')->count() === 0) {
            $this->call(ManDaysSeeder::class);
        }
        if (Schema::hasTable('audit_master_criteria') && DB::table('audit_master_criteria')->count() === 0) {
            $this->call(AuditMasterCriteriaSeeder::class);
        }
        if (Schema::hasTable('audit_team_roles') && DB::table('audit_team_roles')->count() === 0) {
            $this->call(AuditTeamRoleSeeder::class);
        }
        if (Schema::hasTable('audit_master_adjustment_factors') && DB::table('audit_master_adjustment_factors')->count() === 0) {
            $this->call(MasterAdjustmentFactorSeeder::class);
        }
        if (Schema::hasTable('audit_master_eligibilities') && DB::table('audit_master_eligibilities')->count() === 0) {
            $this->call(MasterEligibilitieSeeder::class);
        }
        if (Schema::hasTable('audit_master_safety_performances') && DB::table('audit_master_safety_performances')->count() === 0) {
            $this->call(MasterSafetyPerformanceSeeder::class);
        }

        // 2. Fetch or create Company
        $company = Company::where('company_name', 'PT Alamtri Coal')->first() ?? Company::first();
        if (!$company) {
            $company = Company::create([
                'id' => (string) Str::uuid(),
                'company_name' => 'PT Alamtri Coal',
                'document_code' => 'ATC',
                'type' => 'internal',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Fetch or create Department
        $department = Department::where('company_id', $company->id)->first();
        if (!$department && Schema::hasTable('departments')) {
            $department = Department::create([
                'id' => (string) Str::uuid(),
                'name' => 'Safety, Health & Environment',
                'code' => 'SHE',
                'company_id' => $company->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Create / Update Spatie Roles & Permissions under 'audit' guard
        $permissions = [
            'Audit - Login',
            'Audit - Master Mandays',
            'Audit - Create SMKP',
            'Audit - Detail SMKP',
            'Audit - Detail SMKP Dashboard',
            'Audit - Detail SMKP Notice Letter',
            'Audit - Detail SMKP Audit Plan',
            'Audit - Detail SMKP Implementation Schedule',
            'Audit - Detail SMKP Implementation Report',
            'Audit - Detail SMKP Method and Sample',
            'Audit - Detail SMKP Criteria Audit',
            'Audit - Detail SMKP Criteria Audit Confirmance',
            'Audit - Detail SMKP Criteria Audit Non Confirmance',
            'Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan',
            'Audit - Detail SMKP Audit Fix Recomendation',
            'Audit - Detail SMKP Opening Attendance',
            'Audit - Detail SMKP Closing Attendance',
            'Audit - Detail SMKP Audit Response',
            'Audit - Detail SMKP Report Result',
            'Audit - Detail SMKP Another Attachment',
            'Audit - Lead Auditor',
        ];

        $rolePermissions = [
            'Audit - Super Admin' => $permissions,
            'Audit - Admin' => $permissions,
            'Audit - Lead Auditor' => array_diff($permissions, ['Audit - Master Mandays']),
            'Audit - Auditor' => [
                'Audit - Login',
                'Audit - Detail SMKP',
                'Audit - Detail SMKP Dashboard',
                'Audit - Detail SMKP Method and Sample',
                'Audit - Detail SMKP Criteria Audit',
                'Audit - Detail SMKP Criteria Audit Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan',
                'Audit - Detail SMKP Audit Fix Recomendation',
                'Audit - Detail SMKP Another Attachment'
            ],
            'Audit - Auditee' => [
                'Audit - Login',
                'Audit - Detail SMKP',
                'Audit - Detail SMKP Dashboard',
                'Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan',
                'Audit - Detail SMKP Audit Response'
            ],
            'Audit - Reviewer' => [
                'Audit - Login',
                'Audit - Detail SMKP',
                'Audit - Detail SMKP Dashboard',
                'Audit - Detail SMKP Implementation Report',
                'Audit - Detail SMKP Criteria Audit',
                'Audit - Detail SMKP Criteria Audit Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan',
                'Audit - Detail SMKP Audit Fix Recomendation',
                'Audit - Detail SMKP Opening Attendance',
                'Audit - Detail SMKP Closing Attendance',
                'Audit - Detail SMKP Audit Response',
                'Audit - Detail SMKP Report Result',
                'Audit - Detail SMKP Another Attachment'
            ],
            'Audit - Viewer' => [
                'Audit - Login',
                'Audit - Detail SMKP',
                'Audit - Detail SMKP Dashboard',
                'Audit - Detail SMKP Implementation Report',
                'Audit - Detail SMKP Criteria Audit Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance',
                'Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan',
                'Audit - Detail SMKP Audit Fix Recomendation',
                'Audit - Detail SMKP Opening Attendance',
                'Audit - Detail SMKP Closing Attendance',
                'Audit - Detail SMKP Audit Response',
                'Audit - Detail SMKP Report Result',
                'Audit - Detail SMKP Another Attachment'
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'audit'
            ]);
            $role->syncPermissions($perms);
        }

        // 5. Create / Update Dummy Users for Audit Roles
        $userMapping = [
            'audit.superadmin@alamtri.com' => ['name' => 'Audit Super Admin', 'role' => 'Audit - Super Admin'],
            'audit.admin@alamtri.com' => ['name' => 'Audit Admin', 'role' => 'Audit - Admin'],
            'audit.lead@alamtri.com' => ['name' => 'Audit Lead Auditor', 'role' => 'Audit - Lead Auditor'],
            'audit.auditor@alamtri.com' => ['name' => 'Audit Auditor', 'role' => 'Audit - Auditor'],
            'audit.auditee@alamtri.com' => ['name' => 'Audit Auditee', 'role' => 'Audit - Auditee'],
            'audit.reviewer@alamtri.com' => ['name' => 'Audit Reviewer', 'role' => 'Audit - Reviewer'],
            'audit.viewer@alamtri.com' => ['name' => 'Audit Viewer', 'role' => 'Audit - Viewer'],
        ];

        $seededUsers = [];
        foreach ($userMapping as $email => $data) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'id' => (string) Str::uuid(),
                    'name' => $data['name'],
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'department_id' => $department ? $department->id : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $seededUsers[$email] = $user;

            $role = \Spatie\Permission\Models\Role::where('name', $data['role'])->where('guard_name', 'audit')->first();
            if ($role) {
                DB::table('model_has_roles')->updateOrInsert(
                    ['role_id' => $role->id, 'model_type' => User::class, 'model_id' => $user->id]
                );
            }
        }

        // Direct DB insertion to assign roles to developer user if exists
        $fadjriUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        if ($fadjriUser) {
            $leadRole = \Spatie\Permission\Models\Role::where('name', 'Audit - Lead Auditor')->where('guard_name', 'audit')->first();
            if ($leadRole) {
                DB::table('model_has_roles')->updateOrInsert(
                    ['role_id' => $leadRole->id, 'model_type' => User::class, 'model_id' => $fadjriUser->id]
                );
            }
        }

        $this->command->info('✓ Seeded roles & users from permission matrix.');

        // 6. Clean up existing dummy audit data to prevent duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Audit::where('title', 'like', 'Dummy Audit%')->delete();
        \Modules\Audit\Entities\AuditCriteriaConfirmance::truncate();
        \Modules\Audit\Entities\AuditCriteriaNonConfirmance::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 7. Seed Audit Scenarios for each Status
        $scenarios = [
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::DRAFT,
                'title' => 'Dummy Audit SMKP - Draft Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::ON_GOING,
                'title' => 'Dummy Audit SMKP - On Progress Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::NEED_REVIEW,
                'title' => 'Dummy Audit SMKP - Need Review Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::IN_REVIEW,
                'title' => 'Dummy Audit SMKP - In Review Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::APPROVED,
                'title' => 'Dummy Audit SMKP - Approved Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::REJECTED,
                'title' => 'Dummy Audit SMKP - Rejected Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMKP,
                'status' => BundleStatusEnum::REJECTED_WITH_NOTES,
                'title' => 'Dummy Audit SMKP - Rejected With Notes Scenario',
                'type' => AuditType::INTERNAL
            ],
            [
                'category' => AuditCategory::SMK3,
                'status' => BundleStatusEnum::DRAFT,
                'title' => 'Dummy Audit SMK3 - Draft Scenario',
                'type' => AuditType::EXTERNAL
            ],
            [
                'category' => AuditCategory::ISO45001,
                'status' => BundleStatusEnum::ON_GOING,
                'title' => 'Dummy Audit ISO 45001 - On Progress Scenario',
                'type' => AuditType::EXTERNAL
            ],
            [
                'category' => AuditCategory::ISO9001,
                'status' => BundleStatusEnum::APPROVED,
                'title' => 'Dummy Audit ISO 9001 - Approved Scenario',
                'type' => AuditType::EXTERNAL
            ]
        ];

        // Fetch team roles
        $leadAuditorRoleObj = AuditTeamRole::where('name', 'Lead Auditor')->first();
        $auditorRoleObj = AuditTeamRole::where('name', 'Auditor')->first();
        $dbMethods = \Modules\Audit\Entities\AuditMethod::all();

        foreach ($scenarios as $sc) {
            $audit = Audit::create([
                'title' => $sc['title'],
                'status' => $sc['status'],
                'company_id' => $company->id,
                'audit_type' => $sc['type'],
                'audit_category' => $sc['category'],
                'start_at' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'end_at' => Carbon::now()->addDays(2)->format('Y-m-d'),
            ]);

            // Set up Audit Team
            if ($leadAuditorRoleObj) {
                AuditTeam::create([
                    'audit_id' => $audit->id,
                    'audit_team_role_id' => $leadAuditorRoleObj->id,
                    'user_id' => $seededUsers['audit.lead@alamtri.com']->id,
                    'name' => $seededUsers['audit.lead@alamtri.com']->name,
                    'registration_number' => 'REG-LA-' . rand(100, 999)
                ]);
            }
            if ($auditorRoleObj) {
                AuditTeam::create([
                    'audit_id' => $audit->id,
                    'audit_team_role_id' => $auditorRoleObj->id,
                    'user_id' => $seededUsers['audit.auditor@alamtri.com']->id,
                    'name' => $seededUsers['audit.auditor@alamtri.com']->name,
                    'registration_number' => 'REG-AU-' . rand(100, 999)
                ]);
            }

            // Create Plan & Details
            $plan = $audit->audit_plan()->create([
                'status' => 1
            ]);
            $planDetail = $plan->detail()->create([
                'purpose' => 'Verifikasi kepatuhan terhadap standar regulasi audit.',
                'audit_scope' => 'Seluruh area operasional dan administrasi.',
                'audit_criteria_reference' => 'Standar Audit ' . $sc['category'],
                'site_address' => 'Site Maruwai',
                'address' => 'Jl. Tambang Emas No. 45',
                'relevant_document' => 'SOP, Manual K3L, Logbook Maintenance',
                'facility' => 'Ruang Meeting Utama',
                'reporting_distribution' => 'KTT, Head of SHE, Direktur Utama'
            ]);

            // Create Implementation Activities
            $activity = $audit->implementation_activity()->create([
                'status' => 1
            ]);

            // Seed locations if status !== Draft
            $locations = [];
            if ($sc['status'] !== BundleStatusEnum::DRAFT) {
                $locationNames = ['Workshop Utama', 'Gudang Bahan Kimia', 'Pit East Operation'];
                foreach ($locationNames as $locName) {
                    $locations[] = $audit->locations()->create([
                        'location' => $locName,
                        'is_critical' => rand(0, 1),
                        'status' => 1
                    ]);
                }
            }

            // Copy Criteria from Master Criteria
            $moduleCriteria = $audit->criteria_module()->create([
                'status' => 1
            ]);
            $masterCriteria = AuditMasterCriteria::with(['sub_criteria' => function ($sub) {
                $sub->with('children.list_points', 'list_points');
            }])->where("audit_category", $sc['category'])->get();

            foreach ($masterCriteria as $masterCriterion) {
                $criteria = $moduleCriteria->criteria()->create([
                    'title' => $masterCriterion->title,
                    'subtitle' => $masterCriterion->subtitle,
                    'audit_master_criteria_id' => $masterCriterion->id,
                    'element_value' => $masterCriterion->element_value
                ]);

                foreach ($masterCriterion->sub_criteria as $sub_criterion) {
                    $subCriteria = $criteria->sub_criteria()->create([
                        'title' => $sub_criterion->title,
                        'has_point' => $sub_criterion->has_point,
                        'max_point' => $sub_criterion->max_point,
                        'target_point' => $sub_criterion->target_point,
                        'audit_master_sub_criteria_id' => $sub_criterion->id,
                    ]);
                    foreach ($sub_criterion->list_points as $list_point) {
                        $subCriteria->list_points()->create([
                            'point' => $list_point->point,
                            'tooltip' => $list_point->tooltip,
                            'audit_master_sub_criteria_point_id' => $list_point->id
                        ]);
                    }

                    $hasChildren = $sub_criterion->children->isNotEmpty();

                    // Seed sample method for parent sub-criteria if it has no children
                    if (!$hasChildren && $dbMethods->isNotEmpty()) {
                        $method = $dbMethods->random();
                        DB::table('audit_sub_criteria_sample_methods')->insert([
                            'audit_sub_criteria_id' => $subCriteria->id,
                            'audit_method_id' => $method->id,
                            'sample' => 'Sampel dokumen SOP Kerja ' . rand(1, 5) . ' dan wawancara dengan supervisor.',
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }

                    // Seed location assessment for parent if no children
                    if (!$hasChildren && in_array($sc['status'], [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED]) && !empty($locations)) {
                        foreach ($locations as $loc) {
                            DB::table('audit_sub_criteria_locations')->insert([
                                'id' => (string) Str::uuid(),
                                'audit_location_id' => $loc->id,
                                'audit_sub_criteria_id' => $subCriteria->id,
                                'point' => rand(2, 4),
                                'status' => 1,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }

                    // Seed findings (conformance / non-conformance) for parent if no children
                    if (!$hasChildren && in_array($sc['status'], [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED, BundleStatusEnum::REJECTED, BundleStatusEnum::REJECTED_WITH_NOTES])) {
                        if (rand(1, 5) > 1) {
                            \Modules\Audit\Entities\AuditCriteriaConfirmance::create([
                                'audit_sub_criteria_id' => $subCriteria->id,
                                'audit_team_id' => $audit->auditors()->first()->id ?? null,
                                'status' => 1,
                                'fix_recommendation' => 'Rekomendasi perbaikan berkelanjutan untuk pemeliharaan kriteria.'
                            ]);
                        } else {
                            \Modules\Audit\Entities\AuditCriteriaNonConfirmance::create([
                                'audit_sub_criteria_id' => $subCriteria->id,
                                'audit_team_id' => $audit->auditors()->first()->id ?? null,
                                'problem_description' => 'Ditemukan ketidaksesuaian operasional lapangan pada aspek kriteria ini.',
                                'non_confirmance_description' => 'Dokumen pendukung atau bukti visual tidak lengkap/tidak diperbarui.',
                                'category' => ['minor', 'mayor', 'critical'][rand(0, 2)],
                                'due_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                                'status' => 1,
                                'fix_action' => 'Melakukan tinjauan ulang SOP dan melengkapi seluruh bukti dukung.',
                                'root_cause_investigation' => 'Kurangnya pemahaman tim pengawas terhadap persyaratan baru.',
                                'proof' => 'uploads/audit/dummy_proof.jpg',
                                'is_critical' => rand(0, 1),
                                'is_critical_done' => 0
                            ]);
                        }
                    }

                    foreach ($sub_criterion->children as $child) {
                        $attr = $subCriteria->children()->create([
                            'audit_criteria_id' => $criteria->id,
                            'title' => $child->title,
                            'has_point' => $child->has_point,
                            'max_point' => $child->max_point,
                            'target_point' => $child->target_point,
                            'audit_master_sub_criteria_id' => $child->id
                        ]);
                        foreach ($child->list_points as $point) {
                            $attr->list_points()->create([
                                'point' => $point->point,
                                'tooltip' => $point->tooltip,
                                'audit_master_sub_criteria_point_id' => $point->id
                            ]);
                        }

                        // Seed sample method for children
                        if ($dbMethods->isNotEmpty()) {
                            $method = $dbMethods->random();
                            DB::table('audit_sub_criteria_sample_methods')->insert([
                                'audit_sub_criteria_id' => $attr->id,
                                'audit_method_id' => $method->id,
                                'sample' => 'Sampel bukti uji lapangan ' . rand(10, 50) . ' serta tinjauan dokumen sertifikasi.',
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }

                        // Seed location assessment for children
                        if (in_array($sc['status'], [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED]) && !empty($locations)) {
                            foreach ($locations as $loc) {
                                DB::table('audit_sub_criteria_locations')->insert([
                                    'id' => (string) Str::uuid(),
                                    'audit_location_id' => $loc->id,
                                    'audit_sub_criteria_id' => $attr->id,
                                    'point' => rand(2, 4),
                                    'status' => 1,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]);
                            }
                        }

                        // Seed findings (conformance / non-conformance) for children
                        if (in_array($sc['status'], [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED, BundleStatusEnum::REJECTED, BundleStatusEnum::REJECTED_WITH_NOTES])) {
                            if (rand(1, 5) > 1) {
                                \Modules\Audit\Entities\AuditCriteriaConfirmance::create([
                                    'audit_sub_criteria_id' => $attr->id,
                                    'audit_team_id' => $audit->auditors()->first()->id ?? null,
                                    'status' => 1,
                                    'fix_recommendation' => 'Rekomendasi perbaikan berkelanjutan untuk pemeliharaan kriteria.'
                                ]);
                            } else {
                                \Modules\Audit\Entities\AuditCriteriaNonConfirmance::create([
                                    'audit_sub_criteria_id' => $attr->id,
                                    'audit_team_id' => $audit->auditors()->first()->id ?? null,
                                    'problem_description' => 'Ditemukan ketidaksesuaian operasional lapangan pada aspek kriteria ini.',
                                    'non_confirmance_description' => 'Dokumen pendukung atau bukti visual tidak lengkap/tidak diperbarui.',
                                    'category' => ['minor', 'mayor', 'critical'][rand(0, 2)],
                                    'due_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                                    'status' => 1,
                                    'fix_action' => 'Melakukan tinjauan ulang SOP dan melengkapi seluruh bukti dukung.',
                                    'root_cause_investigation' => 'Kurangnya pemahaman tim pengawas terhadap persyaratan baru.',
                                    'proof' => 'uploads/audit/dummy_proof.jpg',
                                    'is_critical' => rand(0, 1),
                                    'is_critical_done' => 0
                                ]);
                            }
                        }
                    }
                }
            }

            // Create Implementation Report details
            $implementationReport = $audit->implementation_report()->create([
                'status' => 1
            ]);
            $implementationReportDetail = $implementationReport->detail()->create();
            $implementationReportDetail->eligibilities()->sync(AuditMasterEligibility::where('is_active', true)->get());
            $implementationReportDetail->safety_performances()->sync(AuditMasterSafetyPerformance::where('is_active', true)->get());
            $implementationReportDetail->adjustment_factors()->sync(AuditMasterAdjustmentFactor::where('is_active', true)->get());

            // Seed Notice Letter for status other than Draft
            if ($sc['status'] !== BundleStatusEnum::DRAFT) {
                $audit->notice_letters()->create([
                    'url' => 'uploads/audit/dummy_notice.pdf',
                    'original_name' => 'Dummy_Notice_Letter.pdf',
                    'status' => 1
                ]);
            }

            // Seed document files for status >= Need Review
            if (in_array($sc['status'], [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED])) {
                $audit->opening_attendances()->create([
                    'url' => 'uploads/audit/dummy_opening.pdf',
                    'original_name' => 'Opening_Attendance.pdf',
                    'status' => 1
                ]);
                $audit->closing_attendances()->create([
                    'url' => 'uploads/audit/dummy_closing.pdf',
                    'original_name' => 'Closing_Attendance.pdf',
                    'status' => 1
                ]);
                $audit->response_audits()->create([
                    'url' => 'uploads/audit/dummy_response.pdf',
                    'original_name' => 'Response_Audit.pdf',
                    'status' => 1
                ]);
                $audit->report_results()->create([
                    'url' => 'uploads/audit/dummy_report.pdf',
                    'original_name' => 'Final_Report.pdf',
                    'status' => 1
                ]);
            }

            $this->command->info("✓ Seeded Audit Scenario: {$audit->audit_number} - Status: {$audit->status} ({$sc['category']})");
        }
    }
}
