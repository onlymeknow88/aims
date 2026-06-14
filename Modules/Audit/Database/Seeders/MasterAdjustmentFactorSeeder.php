<?php

namespace Modules\Audit\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditMasterAdjustmentFactor;

class MasterAdjustmentFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adjustments = [
            [
                'title' => 'Jarak antar objek audit yang saling berjauhan, dengan waktu tempuh ≥ 4 jam'
            ],
            [
                'title' => 'Perusahaan pertambangan menggunakan lebih dari satu metode penambangan'
            ],
            [
                'title' => 'Perusahaan pertambangan memiliki fasilitas pengolahan dan pemurnian'
            ],
            [
                'title' => 'Tingkat keparahan (severity rate) dan tingkat kekerapan (frequency rate) kecelakaan perusahaan tahun terakhir lebih tinggi dari tingkat rata-rata nasional'
            ],
            [
                'title' => 'Tingkat keparahan penyakit berdasarkan absensi (absence severity rate) dan tingkat kekerapan kesakitan (morbidity frequency rate) perusahaan tahun terakhir lebih tinggi dari tingkat rata-rata nasional'
            ],
            [
                'title' => 'Terjadi kejadian berbahaya serupa dan berulang dalam satu tahun terakhir; dan/atau'
            ],
            [
                'title' => 'Terjadi kejadian akibat penyakit tenaga kerja, dan/atau penyakit akibat kerja dalam satu tahun terakhir.'
            ],
        ];

        foreach ($adjustments as $adjustment):
            AuditMasterAdjustmentFactor::firstOrCreate($adjustment);
        endforeach;
    }
}
