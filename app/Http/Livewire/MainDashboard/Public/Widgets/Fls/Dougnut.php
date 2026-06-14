<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Fls;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [];
    public function mount($result)
    {
        $this->fieldLeadershipApi($result);
    }

    protected $listeners = ['fieldLeadershipApi'];
    public function fieldLeadershipApi($result)
    {
        $this->data = $result['donutChartByActual'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.fls.dougnut');
    }
}
