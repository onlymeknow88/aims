<?php

namespace Modules\CSMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        $guardName = 'csms';

        $permissions = [
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
        ];

        // 1. Create Permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => $guardName
            ]);
        }

        // 2. Define Roles and their Permissions mappings
        $rolesMapping = [
            'CSMS - Admin CSMS' => $permissions, // Gets all permissions
            'CSMS Super Admin' => $permissions,  // Gets all permissions

            'CSMS - Maker' => [
                'CSMS - Dashboard',
                'CSMS - Bidding View Draft',
                'CSMS - Bidding View On Going',
                'CSMS - Bidding Create',
                'CSMS - Bidding Update',
                'CSMS - Bidding Delete',
                'CSMS - Post Bidding View Draft',
                'CSMS - Post Bidding View On Going',
                'CSMS - Renewal View Draft',
                'CSMS - Renewal View On Going',
                'CSMS - Inactive View Draft',
                'CSMS - Inactive View On Going',
                'CSMS - Pjo View Draft',
                'CSMS - Pjo View On Going',
                'CSMS - Pjo Create',
                'CSMS - Pjo Update',
                'CSMS - Pjo Delete',
                'CSMS - Pica View Active',
                'CSMS - Pica View Draft',
                'CSMS - Pica View On Going',
                'CSMS - Dictionary View',
                'CSMS - Letter View',
                'CSMS - Memo KTT View',
            ],

            'CSMS - OHS Reviewer' => [
                'CSMS - Dashboard',
                'CSMS - Dictionary View',
                'CSMS - Letter View',
                'CSMS - Letter Create',
                'CSMS - Letter Update',
                'CSMS - Letter Delete',
                'CSMS - Memo KTT View',
                'CSMS - Bidding View Active',
                'CSMS - Bidding View On Going',
                'CSMS - Bidding Reviewer OHS',
                'CSMS - Post Bidding View Active',
                'CSMS - Post Bidding View On Going',
                'CSMS - Post Bidding Create',
                'CSMS - Post Bidding Update',
                'CSMS - Post Bidding Delete',
                'CSMS - Post Bidding Reviewer OHS',
                'CSMS - Renewal View Active',
                'CSMS - Renewal View On Going',
                'CSMS - Renewal Create',
                'CSMS - Renewal Update',
                'CSMS - Renewal Delete',
                'CSMS - Renewal Reviewer OHS',
                'CSMS - Inactive View Active',
                'CSMS - Inactive View On Going',
                'CSMS - Inactive Create',
                'CSMS - Inactive Update',
                'CSMS - Inactive Delete',
                'CSMS - Inactive Reviewer OHS',
                'CSMS - Pica View Active',
                'CSMS - Pica View On Going',
                'CSMS - Pjo View Active',
                'CSMS - Pjo View On Going',
                'CSMS - Pjo Reviewer OHS',
            ],

            'CSMS - D/H OHS' => [
                'CSMS - Dashboard',
                'CSMS - Dictionary View',
                'CSMS - Letter View',
                'CSMS - Memo KTT View',
                'CSMS - Bidding View Active',
                'CSMS - Bidding View On Going',
                'CSMS - Bidding Reviewer D/H OHS',
                'CSMS - Post Bidding View Active',
                'CSMS - Post Bidding View On Going',
                'CSMS - Post Bidding Reviewer D/H OHS',
                'CSMS - Renewal View Active',
                'CSMS - Renewal View On Going',
                'CSMS - Renewal Reviewer D/H OHS',
                'CSMS - Inactive View Active',
                'CSMS - Inactive View On Going',
                'CSMS - Inactive Reviewer D/H OHS',
                'CSMS - Pica View Active',
                'CSMS - Pica View On Going',
                'CSMS - Pjo View Active',
                'CSMS - Pjo View On Going',
            ],

            'CSMS - KTT' => [
                'CSMS - Dashboard',
                'CSMS - Dictionary View',
                'CSMS - Letter View',
                'CSMS - Memo KTT View',
                'CSMS - Memo KTT Create',
                'CSMS - Memo KTT Update',
                'CSMS - Memo KTT Delete',
                'CSMS - Bidding View Active',
                'CSMS - Bidding View On Going',
                'CSMS - Bidding Reviewer KTT',
                'CSMS - Post Bidding View Active',
                'CSMS - Post Bidding View On Going',
                'CSMS - Post Bidding Reviewer KTT',
                'CSMS - Renewal View Active',
                'CSMS - Renewal View On Going',
                'CSMS - Renewal Reviewer KTT',
                'CSMS - Inactive View Active',
                'CSMS - Inactive View On Going',
                'CSMS - Inactive Reviewer KTT',
                'CSMS - Pica View Active',
                'CSMS - Pica View On Going',
                'CSMS - Pjo View Active',
                'CSMS - Pjo View On Going',
                'CSMS - Pjo Reviewer KTT',
            ],

            'CSMS - Evaluator' => [
                'CSMS - Dashboard',
                'CSMS - Pjo View Active',
                'CSMS - Pjo View On Going',
                'CSMS - Pjo Reviewer Evaluator',
                'CSMS - Pica View Active',
            ]
        ];

        // 3. Create Roles and Assign Permissions
        foreach ($rolesMapping as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guardName
            ]);

            $role->syncPermissions($rolePermissions);
        }
    }
}
