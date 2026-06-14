<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Coe;

use Livewire\Component;
use App\Access\ApiModules;
use App\Models\MainDashboard\NewsAndUpdate;

class Dougnut extends Component
{
    public $data;

    public function mount($result)
    {
        $this->calendarOfEventApi($result);
    }

    protected $listeners = ['calendarOfEventApi'];
    public function calendarOfEventApi($result)
    {
        $this->data = $result['count_annual_completion'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.coe.dougnut');
    }
}
