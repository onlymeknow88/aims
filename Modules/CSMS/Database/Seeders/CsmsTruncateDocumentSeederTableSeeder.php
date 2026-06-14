<?php

namespace Modules\CSMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsDictionary;
use Modules\CSMS\Entities\CsmsLetter;
use Modules\CSMS\Entities\CsmsLetterFile;
use Modules\CSMS\Entities\CsmsMemoKtt;
use Modules\CSMS\Entities\CsmsMemoKttFile;
use Modules\CSMS\Entities\CsmsPjo;
use Modules\CSMS\Entities\CsmsPjoFile;

class CsmsTruncateDocumentSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Bidding::truncate();
        CsmsPjo::truncate();
        CsmsPjoFile::truncate();
        CsmsDictionary::truncate();
        CsmsLetter::truncate();
        CsmsLetterFile::truncate();
        CsmsMemoKtt::truncate();
        CsmsMemoKttFile::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
