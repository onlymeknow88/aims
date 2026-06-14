<?php

namespace App\Http\Livewire\Chart;

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

    //set required label and datasets
    public function mount($labels, $datasets){

        $this->labels = $labels;
        $this->datasets = $datasets;

    }
    
    
    public function render()
    {
        return view('livewire.chart.chart-line')->extends('layouts.section');
    }
}
