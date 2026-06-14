<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Fls;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->fieldLeadershipApi($result);
    }
    
    protected $listeners = ['fieldLeadershipApi'];
    public function fieldLeadershipApi($result)
    {
        try {
            $result = $result['barChartByCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.fls.progress');
    }
}
