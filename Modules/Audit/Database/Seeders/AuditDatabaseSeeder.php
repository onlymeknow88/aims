<?php

namespace Modules\Audit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AuditDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            // PermissionTableSeeder::class,
            // AuditMethodSeederTableSeeder::class,
            // RiskSeveritySeeder::class,
            // ManDaysSeeder::class,
            AuditMasterCriteriaSeeder::class,
            // AuditTeamRoleSeeder::class,
            // MasterAdjustmentFactorSeeder::class,
            // MasterEligibilitieSeeder::class,
            // MasterSafetyPerformanceSeeder::class
        ]);
    }
}
