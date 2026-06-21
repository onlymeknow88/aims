<?php

namespace Modules\CSMS\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\CSMS\CsmsStatus;
use App\Models\BusinessEntity;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Str;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsChecklist;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;
use Modules\CSMS\Enums\ServiceCriteria;

class CSMSDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed users and assign CSMS roles
        $rolesMapping = [
            'CSMS - Maker' => [
                'name' => 'CSMS Maker',
                'email' => 'maker@aims.com',
            ],
            'CSMS - OHS Reviewer' => [
                'name' => 'CSMS OHS Reviewer',
                'email' => 'ohs@aims.com',
            ],
            'CSMS - D/H OHS' => [
                'name' => 'CSMS DH OHS',
                'email' => 'dhohs@aims.com',
            ],
            'CSMS - KTT' => [
                'name' => 'CSMS KTT',
                'email' => 'ktt@aims.com',
            ],
            'CSMS - Evaluator' => [
                'name' => 'CSMS Evaluator',
                'email' => 'evaluator@aims.com',
            ],
            'CSMS - Admin CSMS' => [
                'name' => 'CSMS Admin',
                'email' => 'admin_csms@aims.com',
            ],
        ];

        $maker = null;
        foreach ($rolesMapping as $roleName => $userData) {
            $user = User::where('email', $userData['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => bcrypt('password'),
                ]);
            }
            
            $role = \Spatie\Permission\Models\Role::where('name', $roleName)->where('guard_name', 'csms')->first();
            if ($role) {
                $user->assignRole($role);
            }

            if ($roleName === 'CSMS - Maker') {
                $maker = $user;
            }
        }

        // Prioritize using fadjri.wivindi@alamtri.com as the maker so the dummy biddings show up on their list
        $makerOverride = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
        if ($makerOverride) {
            $maker = $makerOverride;
            
            // Ensure the user has the CSMS - Maker role
            $role = \Spatie\Permission\Models\Role::where('name', 'CSMS - Maker')->where('guard_name', 'csms')->first();
            if ($role) {
                $maker->assignRole($role);
            }
        }

        if (!$maker) {
            $maker = User::first();
        }

        // 2. Get CCOW Company (internal type or first company)
        $ccow = Company::where('type', 'internal')->first() ?? Company::first();
        if (!$ccow) {
            $ccow = Company::create([
                'company_name' => 'PT Demo Internal CCOW',
                'type' => 'internal',
            ]);
        }

        // 3. Get Contractor Company (contractor type or first company)
        $contractor = Company::where('type', 'contractor')->first() ?? Company::first();
        if (!$contractor) {
            $contractor = Company::create([
                'company_name' => 'PT Demo Contractor Parent',
                'type' => 'contractor',
            ]);
        }

        // 4. Get Business Entity
        $businessEntity = BusinessEntity::first();
        if (!$businessEntity) {
            $businessEntity = BusinessEntity::create([
                'name' => 'PT (Perseroan Terbatas)',
            ]);
        }

        // 5. Get master checklists for BIDDING PROCESS
        $masterChecklists = CsmsMasterDataChecklist::where('point', 'BIDDING PROCESS')->get();
        if ($masterChecklists->isEmpty()) {
            // Seed master data check list if empty
            $this->call(CSMSMasterBiddingChecklistTableSeeder::class);
            $masterChecklists = CsmsMasterDataChecklist::where('point', 'BIDDING PROCESS')->get();
        }

        // 6. Define scenarios to seed
        $scenarios = [
            [
                'company_name' => 'PT Contractor Submit Review',
                'status' => CsmsStatus::OnReviewOHS,
                'requested' => CsmsStatus::RequestedOHS,
                'published' => CsmsStatus::Publish,
                'description' => 'Dummy CSMS submitted for review'
            ],
            [
                'company_name' => 'PT Contractor On Review OHS',
                'status' => CsmsStatus::OnReviewOHS,
                'requested' => CsmsStatus::RequestedOHS,
                'published' => CsmsStatus::Publish,
                'description' => 'Dummy CSMS on review OHS'
            ],
            [
                'company_name' => 'PT Contractor DH OHS',
                'status' => CsmsStatus::OnReviewDHOHS,
                'requested' => CsmsStatus::RequestedDHOHS,
                'published' => CsmsStatus::Publish,
                'description' => 'Dummy CSMS on review DH OHS'
            ],
            [
                'company_name' => 'PT Contractor KTT',
                'status' => CsmsStatus::OnReviewKTT,
                'requested' => CsmsStatus::RequestedKTT,
                'published' => CsmsStatus::Publish,
                'description' => 'Dummy CSMS on review KTT'
            ],
            [
                'company_name' => 'PT Contractor Approved Final',
                'status' => CsmsStatus::Approved,
                'requested' => CsmsStatus::Approved,
                'published' => CsmsStatus::Publish,
                'description' => 'Dummy CSMS Approved Final'
            ]
        ];

        foreach ($scenarios as $scenario) {
            $bidding = Bidding::create([
                'maker_id' => $maker->id,
                'criteria' => CsmsStatus::Bidding,
                'classification' => CsmsStatus::KontraktorUtama,
                'ccow_id' => $ccow->id,
                'company_id' => $contractor->id,
                'business_entity_id' => $businessEntity->id,
                'company_name' => $scenario['company_name'],
                'address' => 'Jl. Pahlawan No. 123, Jakarta',
                'company_site' => 'Site Halmahera',
                'license_number' => '123/NIB/CSMS/' . rand(1000, 9999),
                'service_criteria' => ServiceCriteria::Contractor->value,
                'person_in_charge' => 'John Doe PIC',
                'status' => $scenario['status'],
                'requested' => $scenario['requested'],
                'published' => $scenario['published'],
                'date' => now(),
            ]);

            // Add checklists to simulate filled-out submissions
            foreach ($masterChecklists as $mc) {
                CsmsChecklist::create([
                    'bidding_id' => $bidding->id,
                    'question_id' => $mc->id,
                    'point' => $mc->point,
                    'sub_point' => $mc->sub_point,
                    'crtiteria' => $mc->crtiteria,
                    'legal_base' => $mc->legal_base,
                    'note' => $mc->note,
                    'value' => 'Ya',
                    'comment' => 'Sesuai dengan ketentuan dan persyaratan: ' . $scenario['description'],
                ]);
            }
        }
    }
}
