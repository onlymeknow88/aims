<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mcu;

use Livewire\Component;
use App\Access\ApiModules;

class Progress extends Component
{
    public $data = [];

    public function mount($result)
    {
        $this->mcuApi($result);
    }
    
    protected $listeners = ['mcuApi'];
    public function mcuApi($result)
    {
        try {
            $result = $result['count_by_category'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        if (!is_array($this->data)) {
            return view('livewire.main-dashboard.public.error-small');
        }
        return view('livewire.main-dashboard.public.widgets.mcu.progress');
    }
}
