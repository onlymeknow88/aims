<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class SafetyAccountabilityProgram extends Component
{
    public $data = [
        'label' => [],
        'target' => [],
        'actual' => []
    ];

    public function mount($result)
    {
        $this->SapYtdHor($result);
    }

    public function SapYtdHor($result)
    {

        $label = [];
        $target = [];
        $actual = [];
        foreach ($result as $index => $list) {
            array_push($label, $list['name']);
            array_push($target, $list['target']);
            array_push($actual, $list['actual']);
        }

        $this->data = [
            'label' =>  $label,
            'target' =>  $target,
            'actual' => $actual
        ];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.safety-accountability-program');
    }
}
