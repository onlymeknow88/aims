<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Audit;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        "target" => [
            "completed" => 0,
            "ongoing" => 0
        ],
        "actual" => [
            "completed" => 0,
            "ongoing" => 0
        ]
    ];

    public function mount($result)
    {
        $this->auditApi($result);
    }

    protected $listeners = ['auditApi'];
    public function auditApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.audit.dougnut');
    }
}
