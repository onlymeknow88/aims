<?php

namespace App\Http\Livewire\MainDashboard\Public\Components;

use Livewire\Component;

class Gauge extends Component
{
    public $text = 0;
    public $maxValue = 0;

    public function mount($actual, $target)
    {
        $this->text = $actual;
        $this->maxValue = $target;
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.components.gauge');
    }
}
