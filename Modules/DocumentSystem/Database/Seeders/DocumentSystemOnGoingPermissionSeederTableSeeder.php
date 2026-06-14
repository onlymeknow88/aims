<?php

namespace Modules\DocumentSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DocumentSystemOnGoingPermissionSeederTableSeeder extends Seeder
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
                    'Document System - View OnGoing Document',
                ],
                'guard_name' => 'document-system'
            ]
        ];

        $data = array_merge($document_system_role_permission);

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
