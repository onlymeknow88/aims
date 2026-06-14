<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardPermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $document_system_role_permission = [
            [
                'name' => [
                    'Dashboard - Slideshow',
                    'Dashboard - Banner',
                    'Dashboard - General',
                    'Dashboard - Performance',
                    'Dashboard - Safety Performance',
                    'Dashboard - Penghargaan K3LH',
                    'Dashboard - Kegiatan K3LH',
                    'Dashboard - News and Update',
                    'Dashboard - Incident Notification',
                    'Dashboard - Strategi Project',
                    'Dashboard - Attachment',
                    'Dashboard - Production'
                ],
                'guard_name' => 'dashboard'
            ]
        ];

        $data = array_merge($document_system_role_permission);

        foreach ($data as $value) {
            foreach ($value['name'] as $key => $item) {
                Permission::updateOrCreate([
                    'name' => $item,
                    'guard_name' => $value['guard_name']
                ]);
            }
        }
    }
}
