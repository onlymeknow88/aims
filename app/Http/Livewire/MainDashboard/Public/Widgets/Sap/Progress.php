<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Sap;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];

    public function mount($result)
    {
        $this->safetyAccountabilityProgramApi($result);
    }
    
    protected $listeners = ['safetyAccountabilityProgramApi'];
    public function safetyAccountabilityProgramApi($result)
    {
        try {
            $result = $result['by_category'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.sap.progress');
    }
}
