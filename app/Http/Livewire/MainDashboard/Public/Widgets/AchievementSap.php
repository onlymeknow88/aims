<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class AchievementSap extends Component
{
    public $data = [
        'label' => [],
        'target' => [],
        'actual' => []
    ];

    public function mount($result)
    {
        $this->SapYtdDept($result);
    }

    public function SapYtdDept($result)
    {

        $label = [];
        $target = [];
        $actual = [];
        foreach ($result as $index => $list) {
            array_push($label, $index);
            array_push($target, $list['target_dept']);
            array_push($actual, $list['actual_dept']);
        }

        $this->data = [
            'label' =>  $label,
            'target' =>  $target,
            'actual' => $actual
        ];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.achievement-sap');
    }
}
