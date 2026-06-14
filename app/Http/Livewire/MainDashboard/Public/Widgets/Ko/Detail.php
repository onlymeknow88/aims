<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ko;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->safetyOperationApi($result);
    }


    protected $listeners = ['safetyOperationApi'];
    public function safetyOperationApi($result)
    {
        try {
            $count_ytd = $result['ytd'];
            $ytd = $count_ytd['ytd'];
            $line1 = $result['thisMonthEvent'];
            $line2 = $result['lastYearEvent'];
            $this->data = [
                "ytd" => $ytd,
                "data" => [
                    [
                        "name_a" => "Event this month",
                        "a1" => $line1['thisMonth'],
                        "a2_mark" => $line1['thisMonthArrow'],
                        "a3" => $line1['thisMonthActual'],

                        "name_b" => "",
                        "b1" => $line1['lastMonth'],
                        "b2_mark" => $line1['lastMonthArrow'],
                        "b3" => $line1['lastMonthActual'],
                    ],
                    [
                        //line 2
                        "name_a" => "Event this year",
                        "a1" => $line2['thisYear'],
                        "a2_mark" => $line2['thisYearArrow'],
                        "a3" => $line2['thisYearActual'],

                        "name_b" => "",
                        "b1" => $line2['lastYear'],
                        "b2_mark" => $line2['lastYearArrow'],
                        "b3" => $line2['lastYearActual'],
                    ]
                ]
            ];
        } catch (\exception $e) {
        }
    }
    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.ko.detail');
    }
}
