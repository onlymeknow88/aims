<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Widgets;

use Livewire\Component;

class Chart4 extends Component
{
    public $data = [
        'idChart' => [],
        'label' => [],
        'val1' => [],
        'val2' => [],
        'val3' => [],
        'val4' => []
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
        $val1 = [];
        $val2 = [];
        $val3 = [];
        $val4 = [];
        $label = null;
        $label2 = null;
        $label3 = null;
        $label4 = null;

        foreach ($monthly as $key => $list) {
            $labels[] = $list['month'];
            $label = $list['label'] ?? $label;
            $label2 = $list['label2'] ?? $label2;
            $label3 = $list['label3'] ?? $label3;
            $label4 = $list['label4'] ?? $label4;
            $val1[] = $list['count'];
            $val2[] = $list['count2'] ?? $list['count'];
            $val3[] = $list['count3'] ?? $list['count'];
            $val4[] = $list['count4'] ?? $list['count'];
        }

        $this->data = [
            'idChart' => $idChart,
            'labels' => $labels,
            'label' => $label,
            'label2' => $label2,
            'label3' => $label3,
            'label4' => $label4,
            'val1' => $val1,
            'val2' => $val2,
            'val3' => $val3,
            'val4' => $val4
        ];
    }


    public function render()
    {
        return view('csms::livewire.dashboard.widgets.chart4');
    }
}
