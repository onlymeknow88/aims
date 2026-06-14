<?php

namespace App\Http\Livewire\MainDashboard\Public\Components;

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
        return view('livewire.main-dashboard.public.components.vertical-bar-chart');
    }
}
