<?php

namespace Modules\Pica\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pica\Entities\Pica;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Pica\Entities\PicaDocument;

class PicaTruncateDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        PicaDocument::truncate();
        Pica::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
