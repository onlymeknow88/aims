<?php

namespace Modules\FieldLeadership\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;

class FieldLeadershipDocumentSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        FieldLeadershipKtaAndTta::truncate();
        FieldLeadershipPotencyAndConsequnce::truncate();

        $data = file_get_contents(database_path('Seeders/JSON/FieldLeadership/MasterData.json'));
        $data = json_decode($data, true);

        foreach ($data[0]['typeKtaTTA'] as $key => $value) {

            FieldLeadershipKtaAndTta::create([
                'code' => $value['code'],
                'name' => $value['name'],
                'type' => $value['type'],
            ]);
        }

        foreach ($data[1]['potency'] as $key => $value) {

            FieldLeadershipPotencyAndConsequnce::create([
                'name' => $value['name'],
                'code' => $value['code'],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
