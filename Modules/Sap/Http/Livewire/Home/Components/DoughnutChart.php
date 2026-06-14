<?php

namespace Modules\Sap\Http\Livewire\Home\Components;

use Livewire\Component;

class DoughnutChart extends Component
{
    public $idChart = 'doughnutChart';
    public $labels = [];
    public $datasets = [];
    public $legend = true;
    public $width = 100;
    public $height = 100;
    public $labelX = [
        'display'       => false,
        'color'         => 'red',
        'beginAtZero'   => true
    ];
    public function render()
    {
        return view('sap::livewire.home.components.doughnut-chart');
    }
}
