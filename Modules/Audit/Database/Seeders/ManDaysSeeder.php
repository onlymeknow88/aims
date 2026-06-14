<?php

namespace Modules\Audit\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Audit\Entities\AuditManDays;
use Modules\Audit\Entities\AuditRiskSeverity;

class ManDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $man_days = [
            [
                'minimum_people' => 1,
                'maximum_people' => 5,
                'severities' => [
                    ['value' => 3],
                    ['value' => 2.5],
                    ['value' => 2.5],
                ]
            ],
            [
                'minimum_people' => 6,
                'maximum_people' => 10,
                'severities' => [
                    ['value' => 3.5],
                    ['value' => 3],
                    ['value' => 3],
                ]
            ],
            [
                'minimum_people' => 11,
                'maximum_people' => 15,
                'severities' => [
                    ['value' => 4.5],
                    ['value' => 3.5],
                    ['value' => 3],
                ]
            ],
            [
                'minimum_people' => 16,
                'maximum_people' => 25,
                'severities' => [
                    ['value' => 5.5],
                    ['value' => 4.5],
                    ['value' => 3.5],
                ]
            ],
            [
                'minimum_people' => 26,
                'maximum_people' => 45,
                'severities' => [
                    ['value' => 7],
                    ['value' => 5.5],
                    ['value' => 4],
                ]
            ],
            [
                'minimum_people' => 46,
                'maximum_people' => 65,
                'severities' => [
                    ['value' => 8],
                    ['value' => 6],
                    ['value' => 4.5],
                ]
            ],
            [
                'minimum_people' => 66,
                'maximum_people' => 85,
                'severities' => [
                    ['value' => 9],
                    ['value' => 7],
                    ['value' => 5],
                ]
            ],
            [
                'minimum_people' => 86,
                'maximum_people' => 125,
                'severities' => [
                    ['value' => 11],
                    ['value' => 8],
                    ['value' => 5.5],
                ]
            ],
            [
                'minimum_people' => 126,
                'maximum_people' => 175,
                'severities' => [
                    ['value' => 12],
                    ['value' => 9],
                    ['value' => 6],
                ]
            ],
            [
                'minimum_people' => 176,
                'maximum_people' => 275,
                'severities' => [
                    ['value' => 13],
                    ['value' => 10],
                    ['value' => 7],
                ]
            ],
            [
                'minimum_people' => 276,
                'maximum_people' => 425,
                'severities' => [
                    ['value' => 15],
                    ['value' => 11],
                    ['value' => 8],
                ]
            ],
            [
                'minimum_people' => 426,
                'maximum_people' => 625,
                'severities' => [
                    ['value' => 16],
                    ['value' => 12],
                    ['value' => 9],
                ]
            ],
            [
                'minimum_people' => 626,
                'maximum_people' => 875,
                'severities' => [
                    ['value' => 17],
                    ['value' => 13],
                    ['value' => 10],
                ]
            ],
            [
                'minimum_people' => 876,
                'maximum_people' => 1175,
                'severities' => [
                    ['value' => 19],
                    ['value' => 15],
                    ['value' => 11],
                ]
            ],
            [
                'minimum_people' => 1176,
                'maximum_people' => 1550,
                'severities' => [
                    ['value' => 20],
                    ['value' => 16],
                    ['value' => 12],
                ]
            ],
            [
                'minimum_people' => 1551,
                'maximum_people' => 2025,
                'severities' => [
                    ['value' => 21],
                    ['value' => 17],
                    ['value' => 12],
                ]
            ],
            [
                'minimum_people' => 2026,
                'maximum_people' => 2675,
                'severities' => [
                    ['value' => 23],
                    ['value' => 18],
                    ['value' => 13],
                ]
            ],
            [
                'minimum_people' => 2676,
                'maximum_people' => 3450,
                'severities' => [
                    ['value' => 25],
                    ['value' => 19],
                    ['value' => 14],
                ]
            ],
            [
                'minimum_people' => 3451,
                'maximum_people' => 4350,
                'severities' => [
                    ['value' => 27],
                    ['value' => 20],
                    ['value' => 15],
                ]
            ],
            [
                'minimum_people' => 4351,
                'maximum_people' => 5450,
                'severities' => [
                    ['value' => 28],
                    ['value' => 21],
                    ['value' => 16],
                ]
            ],
            [
                'minimum_people' => 5451,
                'maximum_people' => 6800,
                'severities' => [
                    ['value' => 30],
                    ['value' => 23],
                    ['value' => 17],
                ]
            ],
            [
                'minimum_people' => 6801,
                'maximum_people' => 8500,
                'severities' => [
                    ['value' => 32],
                    ['value' => 25],
                    ['value' => 19],
                ]
            ],
            [
                'minimum_people' => 8501,
                'maximum_people' => 10700,
                'severities' => [
                    ['value' => 34],
                    ['value' => 27],
                    ['value' => 20],
                ]
            ],
            [
                'minimum_people' => 10701,
                'maximum_people' => 12950,
                'severities' => [
                    ['value' => 35],
                    ['value' => 29],
                    ['value' => 21],
                ]
            ],
            [
                'minimum_people' => 12951,
                'maximum_people' => 15300,
                'severities' => [
                    ['value' => 37],
                    ['value' => 31],
                    ['value' => 22],
                ]
            ],
            [
                'minimum_people' => 15301,
                'maximum_people' => 17800,
                'severities' => [
                    ['value' => 39],
                    ['value' => 33],
                    ['value' => 23],
                ]
            ],
            [
                'minimum_people' => 17801,
                'maximum_people' => 20500,
                'severities' => [
                    ['value' => 41],
                    ['value' => 35],
                    ['value' => 25],
                ]
            ],
            [
                'minimum_people' => 20501,
                'maximum_people' => 23250,
                'severities' => [
                    ['value' => 42],
                    ['value' => 36],
                    ['value' => 26],
                ]
            ],
            [
                'minimum_people' => 23251,
                'maximum_people' => 26250,
                'severities' => [
                    ['value' => 44],
                    ['value' => 28],
                    ['value' => 27],
                ]
            ],
            [
                'minimum_people' => 26251,
                'maximum_people' => 29250,
                'severities' => [
                    ['value' => 46],
                    ['value' => 40],
                    ['value' => 29],
                ]
            ],
            [
                'minimum_people' => 29251,
                'maximum_people' => 32450,
                'severities' => [
                    ['value' => 48],
                    ['value' => 42],
                    ['value' => 30],
                ]
            ],
            [
                'minimum_people' => 32451,
                'maximum_people' => 35700,
                'severities' => [
                    ['value' => 49],
                    ['value' => 43],
                    ['value' => 31],
                ]
            ],
            [
                'minimum_people' => 35701,
                'maximum_people' => 39050,
                'severities' => [
                    ['value' => 51],
                    ['value' => 45],
                    ['value' => 33],

                ]
            ],
        ];
        $severities = AuditRiskSeverity::get();

        foreach ($man_days as $man_day):
            $manDay = AuditManDays::firstOrCreate(collect($man_day)->except(['severities'])->toArray());
            foreach ($man_day['severities'] as  $key=>$value):
              $manDay->severities()->sync([$severities[$key]->id=>$value],false);
            endforeach;

        endforeach;
    }
}
