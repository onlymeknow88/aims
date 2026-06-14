<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FieldLeadershipKtaAndTta;
use App\Models\FieldLeadershipPotencyAndConsequnce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FieldLeadershipMasterSeeder extends Seeder
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

        $data = file_get_contents(database_path('seeders/JSON/FieldLeadership/MasterData.json'));
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
