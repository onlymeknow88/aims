<?php

namespace Modules\FieldLeadership\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;

class FieldLeadershipMasterDataSeeder extends Seeder
{
    /**
     * Seed master data: categories, parameters, KTA/TTA types, and potency.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ─── Categories ───────────────────────────────────────────────────────
        FieldLeadershipCategory::truncate();

        $categories = [
            'Kondisi Tidak Aman',
            'Tindakan Tidak Aman',
            'Not Applicable',
        ];

        foreach ($categories as $name) {
            FieldLeadershipCategory::create(['name' => $name]);
        }

        // ─── Parameters ───────────────────────────────────────────────────────
        FieldLeadershipParameter::truncate();

        FieldLeadershipParameter::create([
            'max_item_member'           => 3,
            'max_item_positive_condition' => 5,
            'max_item_risk_condition'   => 5,
            'max_item_corrective_action' => 5,
        ]);

        // ─── KTA & TTA Types ──────────────────────────────────────────────────
        FieldLeadershipKtaAndTta::truncate();

        $data = file_get_contents(
            __DIR__ . '/JSON/FieldLeadership/MasterData.json'
        );
        $data = json_decode($data, true);

        foreach ($data[0]['typeKtaTTA'] as $item) {
            FieldLeadershipKtaAndTta::create([
                'code' => $item['code'],
                'name' => $item['name'],
                'type' => $item['type'],
            ]);
        }

        // ─── Potency & Consequence ────────────────────────────────────────────
        FieldLeadershipPotencyAndConsequnce::truncate();

        foreach ($data[1]['potency'] as $item) {
            FieldLeadershipPotencyAndConsequnce::create([
                'code' => $item['code'],
                'name' => $item['name'],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅  FieldLeadership master data seeded.');
    }
}
