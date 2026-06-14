<?php

namespace Modules\Coe\Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'COE - Login',//
            'COE - Superuser',//
            'COE - View List',//
            'COE - View Callendar',//
            'COE - View Detail',//
            'COE - Import Data',//
            'COE - Export Data',//
            'COE - Create COE',//
            'COE - Edit COE',//
            'COE - Delete COE',//
            'COE - Manage Category',//
            'COE - View Dashboard',//
        ];

        foreach ($permissions as $value) {
            Permission::firstOrCreate([
                'name' => $value,
                'guard_name' => 'coe'
            ]);
        }
    }
}
