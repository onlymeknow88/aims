<?php

namespace Modules\DocumentSystem\Http\Livewire\Dashboard;

use Livewire\Component;

class ChartBar extends Component
{
    public $idChart = 'barChart';
    public $labels = [];
    public $datasets = [];
    public $labelX = [
        'display'       => true,
        'color'         => 'red',
        'beginAtZero'   => true
    ];

    //set required label and datasets
    public function mount($labels, $datasets)
    {

        $this->labels = $labels;
        $this->datasets = $datasets;
    }

    public function render()
    {
        return view('documentsystem::livewire.dashboard.chart-bar')->extends('documentsystem::layouts.app');
    }
}
