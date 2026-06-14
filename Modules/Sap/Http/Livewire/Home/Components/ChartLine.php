<?php

namespace Modules\Sap\Http\Livewire\Home\Components;

use Livewire\Component;

class ChartLine extends Component
{
    public $idChart = 'lineChart';
    public $labels = [];
    public $datasets = [];
    public $labelX = [
        'display'       => true,
        'color'         => 'red',
        'beginAtZero'   => true
    ];

    public $labelY = [
        'display'       => true,
        'color'         => 'red',
        'beginAtZero'   => true
    ];

    //set required label and datasets
    public function mount($labels, $datasets){

        $this->labels = $labels;
        $this->datasets = $datasets;

    }
    
    public function render()
    {
        return view('sap::livewire.home.components.chart-line');
    }
}
