<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mr;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->managementResikoApi($result);
    }

    
    protected $listeners = ['managementResikoApi'];
    public function managementResikoApi($result)
    {
        try {
            $result = $result['byCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.mr.progress');
    }
}
