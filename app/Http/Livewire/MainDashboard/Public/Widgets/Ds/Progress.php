<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ds;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->documentSystemApi($result);
    }
    
    protected $listeners = ['documentSystemApi'];
    public function documentSystemApi($result)
    {
        try {
            $result = $result['barChartByCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.ds.progress');
    }
}
