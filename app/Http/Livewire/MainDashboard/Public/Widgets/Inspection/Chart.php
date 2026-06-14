<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Inspection;

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
        $this->inspectionApi($result);
    }


    protected $listeners = ['inspectionApi'];
    public function inspectionApi($result)
    {
        $label = [];
        $target = [];
        $actual = [];
        foreach ($result['completion_by_month'] as $index => $list) {
            array_push($label, ucfirst($index));
            array_push($target, $list['target']);
            array_push($actual, $list['actual']);
        }

        $this->data = [
            'label' =>  $label,
            'target' =>  $target,
            'actual' => $actual
        ];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.inspection.chart');
    }
}
