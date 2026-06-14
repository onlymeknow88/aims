<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ds;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->documentSystemApi($result);
    }

    protected $listeners = ['documentSystemApi'];
    public function documentSystemApi($result)
    {
        try {
            $count_ytd = $result['ytd'];
            $ytd = $count_ytd['target'];

            $line1 = $result['summary_monthly'];
            $line2 = $result['summary_yearly'];

            $this->data = [
                "ytd" => $ytd,
                "data" => [
                    [
                        "name_a" => "Document system this month",
                        "a1" => $line1['this_month_done'],
                        "a2_mark" => $line1['this_month_mark'],
                        "a3" => $line1['this_month_percent'],

                        "name_b" => "",
                        "b1" => $line1['past_month_done'],
                        "b2_mark" =>  $line1['past_month_mark'],
                        "b3" => $line1['past_month_percent'],
                    ],
                    [
                        //line 2
                        "name_a" => "Document system this year",
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
        return view('livewire.main-dashboard.public.widgets.ds.detail');
    }
}
