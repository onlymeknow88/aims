<?php

namespace App\Http\Livewire\MainDashboard\Public\Components;

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
        return view('livewire.main-dashboard.public.components.doughnut-chart');
    }
}
