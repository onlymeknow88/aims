<?php

namespace Modules\Sap\Http\Livewire\Home\Widgets;

use Livewire\Component;

class YearlyChart extends Component
{
    public $data;

    public function render()
    {
        return view('sap::livewire.home.widgets.yearly-chart');
    }
}
