<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Coe;

use Livewire\Component;
use App\Access\ApiModules;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->calendarOfEventApi($result);
    }
    
    protected $listeners = ['calendarOfEventApi'];
    public function calendarOfEventApi($result)
    {
        try {
            $result = $result['count_by_category'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.coe.progress');
    }
}
