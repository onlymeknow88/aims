<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Sap;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->safetyAccountabilityProgramApi($result);
    }

    protected $listeners = ['safetyAccountabilityProgramApi'];
    public function safetyAccountabilityProgramApi($result)
    {
        try {
            $count_ytd = $result['ytd'];
            $ytd = $count_ytd['count'];

            $details = $result['details'];
            $line1 = $details['monthly'];
            $line2 = $details['yearly'];

            $this->data = [
                "ytd" => $ytd,
                "data" => [
                    [
                        "name_a" => "SAP this month",
                        "a1" => $line1['this_month'],
                        "a2_mark" => null,
                        "a3" => $line1['this_month_progress'],

                        "name_b" => "",
                        "b1" => $line1['last_month'],
                        "b2_mark" => null,
                        "b3" => $line1['last_month_progress'],
                    ],
                    [
                        //line 2
                        "name_a" => "SAP this year",
                        "a1" => $line2['this_year'],
                        "a2_mark" => null,
                        "a3" => $line2['this_year_progress'],

                        "name_b" => "",
                        "b1" => $line2['last_year'],
                        "b2_mark" => null,
                        "b3" => $line2['last_year_progress'],
                    ]
                ]
            ];
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.sap.detail');
    }
}
