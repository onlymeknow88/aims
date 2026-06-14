<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Sap;

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
        $this->safetyAccountabilityProgramApi($result);
    }

    protected $listeners = ['safetyAccountabilityProgramApi'];
    public function safetyAccountabilityProgramApi($result)
    {
        $label = [];
        $target = [];
        $actual = [];
        foreach ($result['by_month'] as $index => $list) {
            array_push($label, ucfirst($list['month']));
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
        return view('livewire.main-dashboard.public.widgets.sap.chart');
    }
}
