<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Inspection;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->inspectionApi($result);
    }


    protected $listeners = ['inspectionApi'];
    public function inspectionApi($result)
    {
        try {
            $count_ytd = $result['count_ytd'];
            $ytd = $count_ytd['ytd'];
            $line1 = $result['count_monthly'];
            $line2 = $result['count_yearly'];

            $this->data = [
                "ytd" => $ytd,
                "data" => [
                    [
                        "name_a" => "Event this month",
                        "a1" => $line1['this_month'],
                        "a2_mark" => null,
                        "a3" => $line1['past_month_percentage'],

                        "name_b" => null,
                        "b1" =>  null,
                        "b2_mark" => null,
                        "b3" => null,
                    ],
                    [
                        //line 2
                        "name_a" => "Event this year",
                        "a1" => $line2['this_year'],
                        "a2_mark" => null,
                        "a3" => $line2['past_year_percentage'],

                        "name_b" => null,
                        "b1" => null,
                        "b2_mark" => null,
                        "b3" => null,
                    ]
                ]
            ];
        } catch (\exception $e) {
        }
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.inspection.detail');
    }
}
