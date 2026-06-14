<?php

namespace Modules\Sap\Http\Livewire\Home\Components;

use Livewire\Component;

class HorizontalBarChart extends Component
{
    public $idChart = 'barChart';
    public $labels = [];
    public $datasets = [];    
    public $labelX = [
        'display'       => true,
        'color'         => '#ffffff',
        'beginAtZero'   => true
    ];
    
    public function render()
    {
        return view('sap::livewire.home.components.horizontal-bar-chart');
    }
}
