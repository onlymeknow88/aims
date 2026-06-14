<?php

namespace App\Http\Livewire\MainDashboard\Public\Components;

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
    public function mount($labels, $datasets){

        $this->labels = $labels;
        $this->datasets = $datasets;

    }
    
    public function render()
    {
        return view('livewire.main-dashboard.public.components.chart-line');
    }
}
