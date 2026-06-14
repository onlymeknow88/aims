<?php

namespace Modules\Audit\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditRiskSeverity;

class RiskSeveritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $severities = [
            ['name' => 'High Risk'],
            ['name' => 'Medium Risk'],
            ['name' => 'Low Risk'],
        ];
        foreach ($severities as $severity):
            AuditRiskSeverity::firstOrCreate($severity);
        endforeach;
    }
}
