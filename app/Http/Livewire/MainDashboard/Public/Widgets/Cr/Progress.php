<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Cr;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->complianceRegulationApi($result);
    }
    
    protected $listeners = ['complianceRegulationApi'];
    public function complianceRegulationApi($result)
    {
        try {
            $result = $result['byCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.cr.progress');
    }
}
