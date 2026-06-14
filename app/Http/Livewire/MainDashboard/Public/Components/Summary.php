<?php

namespace App\Http\Livewire\MainDashboard\Public\Components;

use Livewire\Component;

class Summary extends Component
{
    public $data;
    public function mount($data = null)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.components.summary');
    }
}
