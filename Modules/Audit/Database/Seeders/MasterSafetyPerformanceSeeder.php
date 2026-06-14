<?php

namespace Modules\Audit\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditMasterSafetyPerformance;

class MasterSafetyPerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $safetyPerformances = [
            [
                'title' => 'Jumlah Kecelakaan Tambang Berakibat Cidera Ringan'
            ],
            [
                'title' => 'Jumlah Kecelakaan Tambang Berakibat Cidera Berat'
            ],
            [
                'title' => 'Jumlah Kecelakaan Tambang Berakibat Mati'
            ],
            [
                'title' => 'Frequency Rate Kecelakaan Tambang'
            ],
            [
                'title' => 'Severity Rate Kecelakaan Tambang'
            ],
            [
                'title' => 'Jumlah Kejadian Berbahaya'
            ],
            [
                'title' => 'Absence Severity Rate'
            ],
            [
                'title' => 'Morbidity Frequency Rate'
            ],
            [
                'title' => 'Jumlah Kejadian Akibat Penyakit Tenaga Kerja'
            ],
            [
                'title' => 'Frekuensi Penyakit Akibat Kerja'
            ],
        ];

        foreach ($safetyPerformances as $safetyPerformance):
            AuditMasterSafetyPerformance::firstOrCreate($safetyPerformance);
        endforeach;
    }
}
