<?php

namespace Modules\Audit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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

        foreach ($permissions as $value) {
            Permission::firstOrCreate([
                'name' => $value,
                'guard_name' => 'audit'
            ]);
        }
    }
}
