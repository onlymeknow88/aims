<?php

namespace Database\Seeders;

use App\Models\BusinessEntity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'Perusahaan Perseorangan',
            'Firma',
            'Koperasi',
            'Perseroan Komanditer (CV)',
            'Perseroan Terbatas (PT)',
            'Persero (Perseroan Terbatas Negara)',
            'Perusahaan Daerah',
            'Yayasan'
        ];

        foreach ($arr as $item) {
            BusinessEntity::create([
                'name' => $item
            ]);
        }
    }
}
