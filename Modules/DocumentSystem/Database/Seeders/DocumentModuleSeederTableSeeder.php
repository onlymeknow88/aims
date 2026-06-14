<?php

namespace Modules\DocumentSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\DocumentSystem\Entities\Mapping;
use Modules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Entities\ModuleCategory;

class DocumentModuleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Mapping::truncate();
        ModuleCategory::truncate();
        Module::truncate();
        Schema::enableForeignKeyConstraints();

        $modules = [
            [
                'name' => 'Perencanaan',
                'has_document' => false,
                'categories' => [
                    [
                        'name' => 'Bisnis dan Sub Bisnis Process',
                        'mappings' => [
                            'Dokumen BP/SBP',
                        ],
                    ],
                    [
                        'name' => 'HIRA / IBPR',
                        'mappings' => [
                            'Daftar HIRA/IBR', 'Dokumen HIRA/IBPR',
                        ],
                    ],
                    [
                        'name' => 'Risiko Utama - Bowtie Analysis',
                        'mappings' => [
                            'Daftar Bowtie Analysis',
                            'Dokumen Bow Tie',
                            'Daftar 5 Risiko Utama',
                        ],
                    ],
                    [
                        'name' => 'Verifikasi Pengendalian Risiko Utama',
                        'mappings' => [
                            'Verifikasi 2022', 'Verifikasi 2023',
                        ],
                    ],
                    [
                        'name' => 'Identifikasi Peraturan',
                        'mappings' => [
                            'Daftar Peraturan K3', 'Daftar Peraturan Lingkungan',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Organisasi dan Personel',
                'has_document' => false,
                'categories' => [
                    [
                        'name' => 'Struktur Organisasi dan Tanggung Jawab',
                        'mappings' => [
                            'Struktur Organisasi', 'Struktur Organisasi Komite KPLH',
                            'Struktur Organisasi KP', 'Struktur Organisasi KP',
                        ],
                    ],
                    [
                        'name' => 'Penunjukan/Pengesahan',
                        'mappings' => [
                            'KTT', 'PJO', 'Pengawas Operasional', 'Pengawas Teknik',
                            'Tenaga Medis', 'Tenaga Teknis', 'KKO', 'PKO', 'Tim Komisioning',
                            'IHOH', 'Trainer & Induktor',
                        ],
                    ],
                    [
                        'name' => 'Pelatihan dan Kompetensi',
                        'mappings' => [
                            'Matriks Kompetensi', 'Training Need Analysis',
                            'Matriks Pelatihan K3LH', 'Daftar Kompetensi Personel',
                        ],
                    ],
                    [
                        'name' => 'Materi Induksi dan Pelatihan',
                        'mappings' => [
                            'Induksi Tamu', 'Induksi Karyawan', 'Materi Pelatihan Isolasi',
                            'Materi Pelatihan WAH', 'Materi Pelatihan WNW', 'Materi Pelatihan Confined Space',
                            'Materi Pelatihan DDT', 'Materi Pelatihan 5R', 'Materi Pelatihan Hydrocarbon',
                            'Materi Pelatihan ERT',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Implementasi',
                'has_document' => false,
                'categories' => [
                    [
                        'name' => 'Komunikasi dan Konsultasi Internal',
                        'mappings' => [
                            'Pertemuan Komite KPLH', 'Koordinasi Meeting (DMM)',
                            'Pertemuan HSE & Mitra', 'Pertemuan Safety Talk',
                            'P5M',
                        ],
                    ],
                    [
                        'name' => 'Komunikasi dan Konsultasi Eksternal',
                        'mappings' => [
                            'Daftar Komunikasi Eksternal', 'Izin Kerja',
                            'Indash Camera', 'Daftar Alat ',
                        ],
                    ],
                    [
                        'name' => 'Pengelolaan Kendali Operasional',
                        'mappings' => [
                            'Indash Camera',
                        ],
                    ],
                    [
                        'name' => 'Pengelolaan Keselamatan Operasi',
                        'mappings' => [
                            'Register Komisioning 2022', 'Komisioning Fixplant/bangunan 2022',
                            'Komisioning A2B 2022', 'Komisioning LV 2022',
                            'SKPP 2022',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Documentation',
                'has_document' => true,
                'categories' => [
                    [
                        'name' => 'Manual Procedure',
                        'mappings' => [
                            'Manual SMLH',
                        ],
                    ],
                    [
                        'name' => 'Standard Operating Procedure (SOP)',
                        'mappings' => [
                            'CBL', 'STS', 'CMR',
                            'CSR', 'ENV', 'FAC',
                            'GAF', 'GEO', 'GHL',
                        ],
                    ],
                ],
            ],
        ];

        DB::beginTransaction();
        try {
            foreach ($modules as $module) {
                $m = new Module();
                $m->index = implode('_', explode(' ', $module['name']));
                $m->name = $module['name'];
                $m->has_document_number = $module['has_document'];
                $m->save();

                foreach ($module['categories'] as $cat) {
                    $c = new ModuleCategory();
                    $c->module_id = $m->id;
                    $c->index = implode('_', explode(' ', $cat['name']));
                    $c->name = $cat['name'];
                    $c->save();

                    foreach ($cat['mappings'] as $map) {
                        $ma = new Mapping();
                        $ma->category_id = $c->id;
                        $ma->index = implode('_', explode(' ', $map));
                        $ma->name = $map;
                        $ma->save();
                    }
                }
            }
            DB::commit();
            $this->command->info('success');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->command->info('Error in ' . $th->getFile() . ' line ' . $th->getLine() . ' with message ' . $th->getMessage());
        }
    }
}
