<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Widgets;

use Livewire\Component;

class Chart extends Component
{
    public $data = [
        'idChart' => [],
        'label' => [],
        'target' => [],
        'actual' => []
    ];


    public function mount($result, $idChart)
    {
        $this->csmsApi($result, $idChart);
    }

    protected $listeners = ['csmsApi'];

    public function csmsApi($result, $idChart)
    {
        $monthly = $result[$idChart] ?? $result['monthly'];
        $labels = [];
        $target = [];
        $actual = [];
        $label = null;
        $label2 = null;

        foreach ($monthly as $key => $list) {
            $labels[] = $list['month'];
            $label = $list['label'] ?? $label;
            $label2 = $list['label2'] ?? $label2;
            $actual[] = $list['count'];
            $target[] = $list['count2'] ?? $list['count'];
        }

        $this->data = [
            'idChart' => $idChart,
            'labels' => $labels,
            'label' => $label,
            'label2' => $label2,
            'actual' => $actual,
            'target' => $target
        ];
    }


    public function render()
    {
        return view('csms::livewire.dashboard.widgets.chart');
    }
}
