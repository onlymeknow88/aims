<?php

namespace Modules\Pica\Database\Seeders;

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

        $pica = [
            [
                'name' => [
                    // 'Pica - Field Leadership View Document',
                    // 'Pica - Field Leadership Approve Document',

                    // 'Pica - IBPR View Document',
                    'Pica - IBPR View Draft',
                    // 'Pica - IBPR Create Document',
                    // 'Pica - IBPR Approve Document',

                    // 'Pica - Inspeksi KPLH View Document',
                    'Pica - Inspeksi KPLH View Draft',
                    // 'Pica - Inspeksi KPLH Create Document',
                    // 'Pica - Inspeksi KPLH Approve Document',

                    // 'Pica - Audit View Document',
                    'Pica - Audit View Draft',
                    // 'Pica - Audit Create Document',
                    // 'Pica - Audit Approve Document',

                    'Pica - PJA View Request Review',
                    'Pica - PJA View Draft',

                    'Pica - CRS View Request Review',
                ],
                'guard_name' => 'pica'
            ]
        ];

        $data = array_merge($pica);

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
