<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Audit;

use Livewire\Component;

class Detail extends Component
{
    public $data = [
        'ytd' => null,
        'data' => []
    ];

    public function mount($result)
    {
        $this->auditApi($result);
    }

    protected $listeners = ['auditApi'];
    public function auditApi($result)
    {
        try {
            $count_ytd = $result['ytd'];
            $ytd = $count_ytd['actual'];
            $details = $result['barChartByCategory'];

            $detailAll = [];
            foreach($details as $list){
                $detailAll[] = [
                    "name_a" => $list['name'],
                    "a1" => $list['countThisYear'],
                    "a2_mark" => $list['mark'],
                    "a3" => $list['value'],

                    "name_b" => "",
                    "b1" => null,
                    "b2_mark" => null,
                    "b3" => null,
                ];
            }

            $this->data = [
                "ytd" => $ytd,
                "data" =>  $detailAll
            ];
        } catch (\exception $e) {
        }
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.audit.detail');
    }
}
