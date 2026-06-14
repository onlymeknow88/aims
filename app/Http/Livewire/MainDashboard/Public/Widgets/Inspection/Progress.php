<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Inspection;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->inspectionApi($result);
    }

    
    protected $listeners = ['inspectionApi'];
    public function inspectionApi($result)
    {
        try {
            $result = $result['count_by_category'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.inspection.progress');
    }
}
