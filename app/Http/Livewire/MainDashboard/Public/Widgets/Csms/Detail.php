<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Csms;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];


    public function mount($result)
    {
        $this->csmsApi($result);
    }

    protected $listeners = ['csmsApi'];
    public function csmsApi($result)
    {
        //try {
        $ytd = $result['yearly']['ytd'];

        $line1 = isset($result['detail'][0]) ? $result['detail'][0] : null;

        $line2 = isset($result['detail'][1]) ? $result['detail'][1] : null;
        $line3 = isset($result['detail'][2]) ? $result['detail'][2] : null;

        $this->data = [
            "ytd" => $ytd,
            "data" => [
                [
                    "name_a" => isset($line1['name']) ? $line1['name'] : null,
                    "a1" => isset($line1['this_year']) ? $line1['this_year'] : null,
                    "a2_mark" => isset($line1['this_year_mark']) ? $line1['this_year_mark'] : null,
                    "a3" => isset($line1['this_year_percent']) ? $line1['this_year_percent'] : null,

                    "name_b" =>  isset($line2['name']) ? $line2['name'] : null,
                    "b1" =>  isset($line2['this_year']) ? $line2['this_year'] : null,
                    "b2_mark" =>   isset($line2['this_year_mark']) ? $line2['this_year_mark'] : null,
                    "b3" => isset($line2['this_year_percent']) ? $line2['this_year_percent'] : null,
                ],
                [
                    //line 2
                    "name_a" => isset($line3['name']) ? $line3['name'] : null,
                    "a1" => isset($line3['this_year']) ? $line3['this_year'] : null,
                    "a2_mark" => isset($line3['this_year_mark']) ? $line3['this_year_mark'] : null,
                    "a3" => isset($line3['this_year_percent']) ? $line3['this_year_percent'] : null,

                    "name_b" => '',
                    "b1" => '',
                    "b2_mark" => '',
                    "b3" => '',
                ]
            ]
        ];
        //} catch (\exception $e) {
        // }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.csms.detail');
    }
}
