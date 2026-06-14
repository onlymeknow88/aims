<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Components;

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
    public function render()
    {
        return view('csms::livewire.dashboard.components.vertical-bar-chart');
    }
}
