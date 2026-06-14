<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mcu;

use Livewire\Component;

class Dougnut extends Component
{
    public $data;
    public function mount($result)
    {
        $this->mcuApi($result);
    }

    protected $listeners = ['mcuApi'];
    public function mcuApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.mcu.dougnut');
    }
}
