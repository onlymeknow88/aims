<?php

namespace Modules\Sap\Http\Livewire\Home\Widgets;

use Livewire\Component;

class MonthlyChart extends Component
{

    public $data;

    public function render()
    {
        return view('sap::livewire.home.widgets.monthly-chart');
    }
}
