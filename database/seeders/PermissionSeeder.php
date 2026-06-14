<?php

namespace Database\Seeders;

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

        $documentSystem = [
            'Document System - View',
            'Document System - Create',
            'Document System - Read',
            'Document System - Update',
            'Document System - Update Other',
            'Document System - Delete',
            'Document System - Approval',
        ];
        
        
        $mcu = [
            'MCU - View',
            'MCU - Create',
            'MCU - Read',
            'MCU - Update',
            'MCU - Delete',
        ];
        
        $coe = [
            'COE - View',
            'COE - Create',
            'COE - Read',
            'COE - Update',
            'COE - Delete',
        ];

        $data = array_merge($documentSystem, $mcu, $coe);

        foreach ($data as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
