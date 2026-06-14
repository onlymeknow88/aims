<?php

namespace Modules\KPP\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
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
            'KPP - Login',//
            'KPP - Master Library',//
            'KPP - View Peraturan',//
            'KPP - Export Peraturan',//
            'KPP - Create Peraturan',//
            'KPP - Edit Peraturan',//
            'KPP - Create Kepatuhan',//
            'KPP - Approve Kepatuhan',//
            'KPP - Create Ekstraksi',//
            'KPP - Monitoring Ekstraksi',//
            'KPP - PJA/PJO',//
            'KPP - Reviewer',//
            'KPP - PICA',//
        ];

        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'kpp'
            ]);
        }
    }
}
