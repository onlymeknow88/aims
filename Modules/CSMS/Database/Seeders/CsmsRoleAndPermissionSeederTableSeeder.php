<?php

namespace Modules\CSMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class CsmsRoleAndPermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $csms = [
            [
                'name' => [
                    'CSMS - Dashboard',

                    'CSMS - Dictionary View',
                    'CSMS - Dictionary Create',
                    'CSMS - Dictionary Update',
                    'CSMS - Dictionary Delete',

                    'CSMS - Letter View',
                    'CSMS - Letter Create',
                    'CSMS - Letter Update',
                    'CSMS - Letter Delete',

                    'CSMS - Memo KTT View',
                    'CSMS - Memo KTT Create',
                    'CSMS - Memo KTT Update',
                    'CSMS - Memo KTT Delete',

                    'CSMS - Bidding View Active',
                    'CSMS - Bidding View Draft',
                    'CSMS - Bidding View On Going',
                    'CSMS - Bidding Create',
                    'CSMS - Bidding Update',
                    'CSMS - Bidding Delete',
                    'CSMS - Bidding Reviewer OHS',
                    'CSMS - Bidding Reviewer D/H OHS',
                    'CSMS - Bidding Reviewer KTT',

                    'CSMS - Post Bidding View Active',
                    'CSMS - Post Bidding View Draft',
                    'CSMS - Post Bidding View On Going',
                    'CSMS - Post Bidding Create',
                    'CSMS - Post Bidding Update',
                    'CSMS - Post Bidding Delete',
                    'CSMS - Post Bidding Reviewer OHS',
                    'CSMS - Post Bidding Reviewer D/H OHS',
                    'CSMS - Post Bidding Reviewer KTT',

                    'CSMS - Renewal View Active',
                    'CSMS - Renewal View Draft',
                    'CSMS - Renewal View On Going',
                    'CSMS - Renewal Create',
                    'CSMS - Renewal Update',
                    'CSMS - Renewal Delete',
                    'CSMS - Renewal Reviewer OHS',
                    'CSMS - Renewal Reviewer D/H OHS',
                    'CSMS - Renewal Reviewer KTT',

                    'CSMS - Inactive View Active',
                    'CSMS - Inactive View Draft',
                    'CSMS - Inactive View On Going',
                    'CSMS - Inactive Create',
                    'CSMS - Inactive Update',
                    'CSMS - Inactive Delete',
                    'CSMS - Inactive Reviewer OHS',
                    'CSMS - Inactive Reviewer D/H OHS',
                    'CSMS - Inactive Reviewer KTT',

                    'CSMS - Pica View Active',
                    'CSMS - Pica View Draft',
                    'CSMS - Pica View On Going',
                    'CSMS - Pica Create',
                    'CSMS - Pica Update',
                    'CSMS - Pica Delete',

                    'CSMS - Pjo View Active',
                    'CSMS - Pjo View Draft',
                    'CSMS - Pjo View On Going',
                    'CSMS - Pjo Create',
                    'CSMS - Pjo Update',
                    'CSMS - Pjo Delete',
                    'CSMS - Pjo Reviewer OHS',
                    'CSMS - Pjo Reviewer Evaluator',
                    'CSMS - Pjo Reviewer KTT',
                ],
                'guard_name' => 'csms'
            ]
        ];

        $data = array_merge($csms);

        foreach ($data as $value) {
            foreach ($value['name'] as $key => $item) {
                Permission::create([
                    'name' => $item,
                    'guard_name' => $value['guard_name']
                ]);
            }
        }
    }
}
