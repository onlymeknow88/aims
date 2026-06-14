<?php

namespace Modules\Sap\Http\Livewire\Home\Components;

use Livewire\Component;

class VerticalBarChart extends Component
{
    public $idChart = 'barChart';
    public $labels = [];
    public $datasets = [];
    public $labelX = [
        'display'       => true,
        'color'         => '#ffffff',
        'beginAtZero'   => true
    ];

    public $options = [];
    
    public function render()
    {
        return view('sap::livewire.home.components.vertical-bar-chart');
    }
}
