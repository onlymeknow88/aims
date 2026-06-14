<?php

namespace Modules\Audit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Audit\Enums\AuditMethod;

class AuditMethodSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('audit_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        foreach (AuditMethod::asArray() as $value) {
            \Modules\Audit\Entities\AuditMethod::create([
                'name' => $value
            ]);
        }
    }
}
