<?php

namespace Modules\FieldLeadership\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

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

        $fieldLeadership = [
            [
                'name' => [
                    'Field Leadsership - View Active',
                    'Field Leadsership - View Draft',
                    'Field Leadsership - View Request Review For PJA',
                    'Field Leadsership - View Draft For PJA',
                    'Field Leadsership - View Request Review For Approval',
                    'Field Leadsership - Create',
                    'Field Leadsership - Read',
                    'Field Leadsership - Update',
                    'Field Leadsership - Delete',
                ],
                'guard_name' => 'field-leadership'
            ]
        ];

        $data = array_merge($fieldLeadership);

        foreach ($data as $value) {
            foreach ($value['name'] as $key => $item) {
                Permission::firstOrCreate([
                    'name'       => $item,
                    'guard_name' => $value['guard_name'],
                ]);
            }
        }
    }
}
