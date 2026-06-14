<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class ChartDoughnut extends Component
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

    //set required label and datasets
    public function mount($labels, $datasets){

        $this->labels = $labels;
        $this->datasets = $datasets;

    }

    public function render()
    {
        return view('livewire.chart.chart-doughnut')->extends('layouts.section');
    }
}
