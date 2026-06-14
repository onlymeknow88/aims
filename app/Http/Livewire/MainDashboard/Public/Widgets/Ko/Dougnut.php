<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ko;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        'completed' => [
            'completed' => 0,
            'ongoing' =>  0
        ],
        'issue' => [
            'completed' =>  0,
            'ongoing' => 0
        ]
    ];

    public function mount($result)
    {
        $this->safetyOperationApi($result);
    }


    protected $listeners = ['safetyOperationApi'];
    public function safetyOperationApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.ko.dougnut');
    }
}
