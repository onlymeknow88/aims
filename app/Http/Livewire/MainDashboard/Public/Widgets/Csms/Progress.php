<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Csms;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];


    public function mount($result)
    {
        $this->csmsApi($result);
    }

    protected $listeners = ['csmsApi'];
    public function csmsApi($result)
    {
        $this->data = $result['category'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.csms.progress');
    }
}
