<?php

namespace Database\Seeders;

use App\Models\DocumentSystem\Mapping;
use App\Models\DocumentSystem\Module;
use App\Models\DocumentSystem\ModuleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::factory(4)
            ->has(ModuleCategory::factory()->count(5)
                ->has(Mapping::factory()->count(5)), 'categories')
            ->create();
    }
}
