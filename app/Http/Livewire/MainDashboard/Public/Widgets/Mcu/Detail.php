<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mcu;

use Livewire\Component;
use App\Access\ApiModules;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->mcuApi($result);
    }

    protected $listeners = ['mcuApi'];
    public function mcuApi($result)
    {
        $count_ytd = $result['count_ytd'];
        $ytd = $count_ytd['ytd'];
        $line1 = $result['count_annual_completion']['thisYear'];
        $this->data = [
            "ytd" => $ytd,
            "data" => [
                [
                    "name_a" => "Unfit",
                    "a1" => $line1['unfit'],
                    "a2_mark" => null,
                    "a3" => $line1['unfit_percent'],

                    "name_b" => "Currencly Unfit",
                    "b1" => $line1['curently_unfit'],
                    "b2_mark" => null,
                    "b3" => $line1['curently_unfit_percent'],
                ],
                [
                    "name_a" => "Fit",
                    "a1" => $line1['fit'],
                    "a2_mark" => null,
                    "a3" => $line1['fit_percent'],

                    "name_b" => "Fit with Recomendation",
                    "b1" => $line1['fit_with_recomendation'],
                    "b2_mark" => null,
                    "b3" => $line1['fit_with_recomendation_percent'],
                ]
            ]
        ];
    }


    public function render()
    {
        if (!is_array($this->data)) {
            return view('livewire.main-dashboard.public.error-small');
        }
        return view('livewire.main-dashboard.public.widgets.mcu.detail');
    }
}
