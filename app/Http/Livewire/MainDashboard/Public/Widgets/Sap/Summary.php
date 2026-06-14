<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Sap;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->safetyAccountabilityProgramApi($result);
    }
    
    protected $listeners = ['safetyAccountabilityProgramApi'];
    public function safetyAccountabilityProgramApi($result)
    {
        try {
            $result = $result['ytd'];

            $actual = $result['count'];
            $progress = $result['progress'];
            $progress = round($progress, 2);

            $this->data = [
                'count' => $actual,
                'progress' => $progress
            ];
           
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.sap.summary');
    }
}
