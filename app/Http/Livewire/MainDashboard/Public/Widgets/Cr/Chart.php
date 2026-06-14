<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Cr;

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
        $this->complianceRegulationApi($result);
    }

    protected $listeners = ['complianceRegulationApi'];
    public function complianceRegulationApi($result)
    {
        $label = [];
        $target = [];
        $actual = [];
        foreach ($result['byMonth'] as $index => $list) {
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
        return view('livewire.main-dashboard.public.widgets.cr.chart');
    }
}
