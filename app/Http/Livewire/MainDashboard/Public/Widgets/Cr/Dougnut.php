<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Cr;

use Livewire\Component;

class Dougnut extends Component
{
    public $data = [
        'complied' => [
            'target' => 0,
            'actual' => 0
        ],
        'notcomply' => [
            'target' => 0,
            'actual' =>  0
        ]
    ];

    public function mount($result)
    {
        $this->complianceRegulationApi($result);
    }

    protected $listeners = ['complianceRegulationApi'];
    public function complianceRegulationApi($result)
    {
        $this->data = $result['progress'];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.cr.dougnut');
    }
}
