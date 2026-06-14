<?php

namespace Modules\FieldLeadership\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class FieldLeadershipDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call([
            PermissionSeederTableSeeder::class,
            FieldLeadershipMasterDataSeeder::class,
            FieldLeadershipDummyDocumentSeeder::class,
        ]);

        Model::reguard();
    }
}
