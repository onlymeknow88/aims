<?php

namespace App\Http\Livewire\Dashboard\Components;

use Livewire\Component;

class Gauge extends Component
{
    public $textCenter = '50%';
    public $percent = 50;

    public function render()
    {
        return view('livewire.dashboard.components.gauge');
    }
}
