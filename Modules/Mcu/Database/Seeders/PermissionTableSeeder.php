<?php

namespace Modules\Mcu\Database\Seeders;

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
            'MCU - Login',//
            'MCU - View List MCU Medical Staff',//
            'MCU - View Detail MCU Medical Staff',//
            'MCU - Import Data MCU',//
            'MCU - Export Data MCU',//
            'MCU - Create MCU',//
            'MCU - Edit MCU',//
            'MCU - Delete MCU',//
            'MCU - Manage Formula MCU',//
            'MCU - Manage Provider MCU',//
            'MCU - View Dashboard MCU',//
            'MCU - View List MCU Doctor',//
            'MCU - View Detail MCU Doctor',//
            'MCU - Create Summary Doctor',//
            'MCU - View MCU Patient',//
        ];

        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'mcu'
            ]);
        }
    }
}
