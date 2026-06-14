<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ko;

use Livewire\Component;

class Progress extends Component
{
    public $data = [];
    
    public function mount($result)
    {
        $this->safetyOperationApi($result);
    }
    
    protected $listeners = ['safetyOperationApi'];
    public function safetyOperationApi($result)
    {
        try {
            $result = $result['byCategory'];
            $this->data = $result;
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.ko.progress');
    }
}
