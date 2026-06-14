<?php

namespace Modules\Audit\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditMasterEligibility;

class MasterEligibilitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eligibilities = [
            [
                'title' => 'Informasi untuk Pengembangan Program Audit: Profil Organisasi'
            ],
            [
                'title' => 'Informasi untuk Pengembangan Program Audit: Profil Risiko'
            ],
            [
                'title' => 'Informasi untuk Pengembangan Program Audit: Data Kinerja Keselamatan Pertambangan pada Periode Audit'
            ],
            [
                'title' => 'Kerjasama dari Auditi'
            ],
            [
                'title' => 'Ketersediaan Waktu'
            ],
            [
                'title' => 'Ketersediaan Sumberdaya lainnya'
            ],
            [
                'title' => 'Pemenuhan Persyaratan Keselamatan dan Keamanan'
            ],
        ];

        foreach ($eligibilities as $eligibility):
            AuditMasterEligibility::firstOrCreate($eligibility);
        endforeach;
    }
}
