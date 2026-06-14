<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Inspection;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        'target' => [
            'complete' => 0,
            'ongoing' => 0
        ],
        'actual' => [
            'complete' => 0,
            'ongoing' => 0
        ]
    ];

    public function mount($result)
    {
        $this->inspectionApi($result);
    }


    protected $listeners = ['inspectionApi'];
    public function inspectionApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.inspection.dougnut');
    }
}
