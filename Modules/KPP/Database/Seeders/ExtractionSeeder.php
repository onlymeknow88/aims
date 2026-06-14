<?php

namespace Modules\KPP\Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\KPP\Entities\KppArticle;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppExtractionFile;
use Modules\KPP\Entities\KppExtractionTransaction;
use Modules\KPP\Entities\KppObedience;
use Modules\KPP\Entities\KppObedienceEmail;
use Modules\KPP\Entities\KppObedienceRequest;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Entities\KppRuleFile;
use Spatie\Permission\Models\Permission;

class ExtractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        KppExtractionFile::truncate();
        KppArticle::truncate();
        KppExtractionTransaction::truncate();
        KppExtraction::truncate();
        KppObedienceEmail::truncate();
        KppObedienceRequest::truncate();
        KppObedience::truncate();
        KppRuleFile::truncate();
        KppRule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
