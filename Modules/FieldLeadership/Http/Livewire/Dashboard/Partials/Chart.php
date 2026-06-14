<?php

namespace Modules\FieldLeadership\Http\Livewire\Dashboard\Partials;

use Livewire\Component;

class Chart extends Component
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
        return view('fieldleadership::livewire.dashboard.partials.chart')->layout('fieldleadership::layouts.app');
    }
}
