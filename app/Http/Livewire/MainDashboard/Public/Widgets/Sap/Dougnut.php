<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Sap;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        'update' => [
            'target' => 0,
            'actual' => 0
        ],
        'obsolute' => [
            'target' => 0,
            'actual' => 0
        ]
    ];

    public function mount($result)
    {
        $this->safetyAccountabilityProgramApi($result);
    }

    protected $listeners = ['safetyAccountabilityProgramApi'];
    public function safetyAccountabilityProgramApi($result)
    {
        $this->data = $result['progress'];
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.sap.dougnut');
    }
}
