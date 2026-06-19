<?php

namespace Modules\Pica\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $picaPermissions = [
            'Pica - Field Leadership View Document',
            'Pica - Field Leadership Approve Document',
            'Pica - IBPR View Draft',
            'Pica - Inspeksi KPLH View Draft',
            'Pica - Audit View Draft',
            'Pica - PJA View Request Review',
            'Pica - PJA View Draft',
            'Pica - CRS View Request Review',
        ];

        $permissionModels = [];
        foreach ($picaPermissions as $item) {
            $permissionModels[$item] = Permission::firstOrCreate([
                'name' => $item,
                'guard_name' => 'pica'
            ]);
        }

        // Create Roles
        $makerRole = Role::firstOrCreate(['name' => 'PICA - Maker', 'guard_name' => 'pica']);
        $pjaRole = Role::firstOrCreate(['name' => 'PICA - Approval PJA', 'guard_name' => 'pica']);
        $crsRole = Role::firstOrCreate(['name' => 'PICA - Approval CRS', 'guard_name' => 'pica']);
        $superAdminRole = Role::firstOrCreate(['name' => 'PICA - Super Admin', 'guard_name' => 'pica']);

        // Sync permissions to roles
        $makerRole->syncPermissions([
            $permissionModels['Pica - IBPR View Draft'],
            $permissionModels['Pica - Inspeksi KPLH View Draft'],
            $permissionModels['Pica - Audit View Draft'],
            $permissionModels['Pica - PJA View Draft'],
            $permissionModels['Pica - Field Leadership View Document'],
        ]);

        $pjaRole->syncPermissions([
            $permissionModels['Pica - PJA View Request Review'],
            $permissionModels['Pica - PJA View Draft'],
            $permissionModels['Pica - Field Leadership View Document'],
        ]);

        $crsRole->syncPermissions([
            $permissionModels['Pica - CRS View Request Review'],
            $permissionModels['Pica - Field Leadership View Document'],
            $permissionModels['Pica - Field Leadership Approve Document'],
        ]);

        $superAdminRole->syncPermissions(Permission::where('guard_name', 'pica')->get());
    }
}
