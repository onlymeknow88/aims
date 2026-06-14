<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mr;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        'update' => [
            'completed' => 0,
            'ongoing' =>  0
        ],
        'opsolute' => [
            'completed' => 0,
            'ongoing' => 0
        ]
    ];

    public function mount($result)
    {
        $this->managementResikoApi($result);
    }

    protected $listeners = ['managementResikoApi'];
    public function managementResikoApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.mr.dougnut');
    }
}
