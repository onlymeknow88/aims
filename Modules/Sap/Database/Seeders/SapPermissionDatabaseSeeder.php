<?php

namespace Modules\Sap\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SapPermissionDatabaseSeeder extends Seeder
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
                    'SAP - Dashboard',
                    'SAP - Summary',
                    'SAP - Monthly',
                    'SAP - Setup',
                ],
                'guard_name' => 'sap'
            ]
        ];

        $data = array_merge($document_system_role_permission);

        foreach ($data as $value) {
            foreach ($value['name'] as $key => $item) {
                Permission::updateOrCreate(
                    [
                        'name' => $item,
                        'guard_name' => $value['guard_name']
                    ]
                );
            }
        }
    }
}
