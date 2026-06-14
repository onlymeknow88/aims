<?php

namespace Modules\Kplh\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\InspectionRisks;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\KplhLabelIO;

class KplhTruncateSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        KplhLabelIO::truncate();
        InspectionRisks::truncate();
        InspectionData::truncate();
        KplhLabel::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
