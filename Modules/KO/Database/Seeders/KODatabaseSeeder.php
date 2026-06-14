<?php

namespace Modules\KO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class KODatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(
            SpipSeeder::class
        );

        $this->call(
            PermissionTableSeeder::class
        );
    }
}
