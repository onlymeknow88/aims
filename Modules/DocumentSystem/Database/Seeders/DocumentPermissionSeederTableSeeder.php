<?php

namespace Modules\DocumentSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DocumentPermissionSeederTableSeeder extends Seeder
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
                    'Document System - View Active Document',
                    'Document System - View OnGoing Document',
                    'Document System - View Obsolate Document',
                    'Document System - View Draft Document',
                    'Document System - Export Document',
                    'Document System - Create Document',
                    'Document System - Edit Document',
                    'Document System - Delete Document',

                    'Document System - View Active JSA',
                    'Document System - View Obsolate JSA',
                    'Document System - View Draft JSA',
                    'Document System - Export JSA',
                    'Document System - Create JSA',
                    'Document System - Edit JSA',
                    'Document System - Delete JSA',

                    'Document System - View Active PTW',
                    'Document System - Export PTW',
                    'Document System - Create PTW',
                    'Document System - Delete PTW',

                    'Document System - Master Data',

                    'Document System - Approve Document Level 1',
                    'Document System - Approve Document Level 2',
                ],
                'guard_name' => 'document-system'
            ]
        ];

        $data = array_merge($document_system_role_permission);

        foreach ($data as $value) {
            foreach ($value['name'] as $key => $item) {
                Permission::firstOrCreate([
                    'name' => $item,
                    'guard_name' => $value['guard_name']
                ]);
            }
        }
    }
}
