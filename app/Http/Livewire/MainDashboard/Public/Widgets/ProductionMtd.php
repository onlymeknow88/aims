<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class ProductionMtd extends Component
{
    public $dataCategory = [];
    public $dataProgress = [];

    public function mount($result)
    {
        $this->ProductionMtd($result);
    }

    protected $listeners = ['ProductionMtd'];
    public function ProductionMtd($result)
    {
        $color = ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#ECF39E'];

        $category = $result['category'];
        $label = [];
        $datasets = [];
        foreach ($category as $index => $list) {
            $label[] = $list['category'];
            $datasets[] = $list['total'];
        }

        $this->dataCategory = [
            'labels' => $label,
            'datasets' => $datasets
        ];

        //progress
        $this->dataProgress = $result['progress'];
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.production-mtd');
    }
}
