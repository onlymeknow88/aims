<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Coe;

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
        $this->calendarOfEventApi($result);
    }

    protected $listeners = ['calendarOfEventApi'];
    public function calendarOfEventApi($result)
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
                        "a1" => $line1['this_month_done'],
                        "a2_mark" => $line1['this_month_mark'],
                        "a3" => $line1['this_month_percent'],

                        "name_b" => "",
                        "b1" => $line1['past_month_done'],
                        "b2_mark" => $line1['past_month_mark'],
                        "b3" => $line1['past_month_percent'],
                    ],
                    [
                        //line 2
                        "name_a" => "Event this year",
                        "a1" => $line2['this_year_done'],
                        "a2_mark" => $line2['this_year_mark'],
                        "a3" => $line2['this_year_percent'],

                        "name_b" => "",
                        "b1" => $line2['past_year_done'],
                        "b2_mark" => $line2['past_year_mark'],
                        "b3" => $line2['past_year_percent'],
                    ]
                ]
            ];
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.coe.detail');
    }
}
