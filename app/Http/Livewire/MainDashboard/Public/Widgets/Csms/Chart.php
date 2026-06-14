<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Csms;

use Livewire\Component;

class Chart extends Component
{
    public $data = [
        'label' => [],
        'target' => [],
        'actual' => []
    ];


    public function mount($result)
    {
        $this->csmsApi($result);
    }

    protected $listeners = ['csmsApi'];
    public function csmsApi($result)
    {

        $monthly = $result['monthly'];
        $labels = [];
        $target = [];
        $actual = [];
        foreach ($monthly as $list) {
            $labels[] = $list['month'];
            $actual[] = $list['count'];
        }
        $this->data = [
            'labels' => $labels,
            'actual' => $actual,
            'target' => $target
        ];
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.csms.chart');
    }
}
