<?php

namespace Modules\Audit\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditTeamRole;

class AuditTeamRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Lead Auditor'],
            ['name' => 'Auditor'],
            ['name' => 'Observer'],
        ];

        foreach ($roles as $role):
            AuditTeamRole::firstOrCreate($role);
        endforeach;
    }
}
