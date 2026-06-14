<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ds;

use Livewire\Component;

class Dougnut extends Component
{
    public $data;
    public function mount($result)
    {
        $this->documentSystemApi($result);
    }

    protected $listeners = ['documentSystemApi'];
    public function documentSystemApi($result)
    {
        $this->data = $result['donut'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.ds.dougnut');
    }
}
