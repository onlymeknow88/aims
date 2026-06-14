<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Audit;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->auditApi($result);
    }
    
    protected $listeners = ['auditApi'];
    public function auditApi($result)
    {
        try {
            $result = $result['barChartByCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.audit.progress');
    }
}
