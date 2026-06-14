<?php

namespace Modules\Sap\Http\Livewire\Home\Components;

use Livewire\Component;

class Gauge extends Component
{
    public $textCenter = '50%';
    public $percent = 50;

    public function render()
    {
        return view('sap::livewire.home.components.gauge');
    }
}
