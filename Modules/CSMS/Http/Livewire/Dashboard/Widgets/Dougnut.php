<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Widgets;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [];
    public function mount($result)
    {
        $this->csmsApi($result);
    }

    protected $listeners = ['csmsApi'];
    public function csmsApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('csms::livewire.dashboard.widgets.dougnut');
    }
}
