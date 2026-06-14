<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Audit;

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
        $this->auditApi($result);
    }

    protected $listeners = ['auditApi'];
    public function auditApi($result)
    {
        $label = [];
        $target = [];
        $actual = [];
        foreach ($result['barChartByMonth'] as $index => $list) {
            array_push($label, $index);
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
        return view('livewire.main-dashboard.public.widgets.audit.chart');
    }
}
