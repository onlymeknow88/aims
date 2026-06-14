<?php

namespace Modules\Coe\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Coe\Entities\Event;
use Illuminate\Database\Eloquent\Model;

class CoETruncateSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Event::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
