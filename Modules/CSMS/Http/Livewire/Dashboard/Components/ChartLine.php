<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Components;

use Livewire\Component;

class ChartLine extends Component
{
    public $idChart = 'lineChart';
    public $labels = [];
    public $datasets = [];
    public $labelX = [
        'display'       => true,
        'color'         => '#57D989',
        'beginAtZero'   => true
    ];

    public $labelY = [
        'display'       => true,
        'color'         => 'red',
        'beginAtZero'   => true
    ];

    //set required label and datasets
    public function mount($labels, $datasets)
    {

        $this->labels = $labels;
        $this->datasets = $datasets;
    }

    public function render()
    {
        return view('csms::livewire.dashboard.components.chart-line');
    }
}
