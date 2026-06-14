<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Components;

use Livewire\Component;

class DoughnutChartTextCenter extends Component
{
    public $idChart = 'doughnutChart';
    public $labels = [];
    public $datasets = [];
    public $legend = true;
    public $width = 100;
    public $height = 100;
    public $textCenter = '';
    public $labelX = [
        'display'       => false,
        'color'         => 'red',
        'beginAtZero'   => true
    ];
    public function render()
    {
        return view('csms::livewire.dashboard.components.doughnut-chart-text-center');
    }
}
