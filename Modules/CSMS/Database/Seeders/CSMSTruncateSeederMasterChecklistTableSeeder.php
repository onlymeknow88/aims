<?php

namespace Modules\CSMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;


class CSMSTruncateSeederMasterChecklistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        CsmsMasterDataChecklist::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
