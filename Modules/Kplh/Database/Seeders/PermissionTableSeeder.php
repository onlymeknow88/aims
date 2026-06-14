<?php

namespace Modules\Kplh\Database\Seeders;

use Illuminate\Database\Seeder;
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
            'KPLH - Login', //
            'KPLH - View Dashboard', //
            'KPLH - Approval', //

            'KPLH - View List Food Hygiene', //
            'KPLH - View Detail Food Hygiene', //
            'KPLH - Create Food Hygiene', //
            'KPLH - Edit Food Hygiene', //
            'KPLH - Delete Food Hygiene', //

            'KPLH - View List Workplace', //
            'KPLH - View Detail Workplace', //
            'KPLH - Create Workplace', //
            'KPLH - Edit Workplace', //
            'KPLH - Delete Workplace', //

            'KPLH - View List Area Maintank', //
            'KPLH - View Detail Area Maintank', //
            'KPLH - Create Area Maintank', //
            'KPLH - Edit Area Maintank', //
            'KPLH - Delete Area Maintank', //

            'KPLH - View List Area Jetty', //
            'KPLH - View Detail Area Jetty', //
            'KPLH - Create Area Jetty', //
            'KPLH - Edit Area Jetty', //
            'KPLH - Delete Area Jetty', //

            'KPLH - View List K3', //
            'KPLH - View Detail K3', //
            'KPLH - Create K3', //
            'KPLH - Edit K3', //
            'KPLH - Delete K3', //
        ];

        foreach ($permissions as $value) {
            Permission::firstOrCreate([
                'name' => $value,
                'guard_name' => 'kplh',
            ]);
        }
    }
}
