<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Components;

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
        return view('csms::livewire.dashboard.components.summary');
    }
}
