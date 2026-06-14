<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class SapYtd extends Component
{
    public $data = [
        'label' => [],
        'target' => [],
        'actual' => []
    ];

    public $dataCategory = [
        'label' => [],
        'target' => [],
        'actual' => []
    ];

    public $dataProccess = [
        'target' => 0,
        'actual' => 0
    ];

    public function mount($result, $category)
    {
        $this->SapYtdVer($result, $category);
    }

    public function SapYtdVer($result, $category)
    {

        $label = [];
        $target = [];
        $actual = [];
        foreach ($result as $index => $list) {
            array_push($label, date('M', strtotime($list['month'])));
            array_push($target, $list['target']);
            array_push($actual, $list['actual']);
        }

        $this->data = [
            'label' =>  $label,
            'target' =>  $target,
            'actual' => $actual
        ];

        $label = [];
        $target = [];
        $actual = [];
        foreach ($category as $index => $list) {
            array_push($label, $list['name']);
            array_push($target, $list['target']);
            array_push($actual, $list['actual']);
        }

        $this->dataCategory =  [
            'label' =>  $label,
            'target' =>  $target,
            'actual' => $actual
        ];

        $target = collect($category)->sum('target');
        $actual = collect($category)->sum('actual');
        $this->dataProccess = [
            'target' =>  $target,
            'actual' => $actual
        ];
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.sap-ytd');
    }
}
