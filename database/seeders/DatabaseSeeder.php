<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\CompanyType;
use Illuminate\Database\Seeder;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(3)
            ->has(Department::factory()->count(5)
                ->has(Section::factory()->count(5))
                ->has(User::factory()->count(10))
            )
            ->create();
        Company::factory(1)
            ->has(Department::factory()->count(1)
                ->has(Section::factory()->count(1))
                ->has(User::factory()->count(1))
                ->has(User::factory()->state([
                    'email'=>'user_internal@gmail.com'
                ])->count(1))
            )
            ->create();


        foreach (\App\Models\User::all() as $user) {
            $section = \App\Models\Section::inRandomOrder()->first();

            $areaManager = AreaManager::create([
                'user_id' => $user->id,
                'section_id' => $section->id,
            ]);
        }

        $this->call(DocumentModuleSeeder::class);

        Company::factory(1)->state([
            'type'=>CompanyType::Contractor()->value
        ])
            ->has(Department::factory()->count(1)
                ->has(Section::factory()->count(1))
                ->has(User::factory()->state([
                    'email'=>'user_contractor@gmail.com'
                ])->count(1))
            )
            ->create();

            $this->call(DashboardPermissionDatabaseSeeder::class);

    }
}
