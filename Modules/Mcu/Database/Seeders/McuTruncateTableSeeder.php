<?php

namespace Modules\Mcu\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Mcu\Entities\MedicalHistory;

class McuTruncateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        MedicalHistory::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
