<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class ProductionYtdChart extends Component
{
    public $dataBlock = [];
    public $dataLine = [];

    public function mount($result)
    {
        $this->ProductionYtd($result);
    }

    protected $listeners = ['ProductionYtd'];
    public function ProductionYtd($result)
    {
        $color = ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#ECF39E'];
        //category
        $dataCategory = $result['category'];
        $category = collect($dataCategory)->pluck('category');
        $category->all();

        //yearly
        $yearly = $result['yearly'];
        $label = [];
        foreach ($yearly as $index => $list) {
            $label[] =  $list['year'];
        }

        $datasets = [];
        foreach ($category as $index => $cat) {
            $totalAll = [];
            foreach ($yearly as $indexYearly => $list) {
                $resultCat = collect($list['category'])->FirstWhere('name', $cat);
                $totalAll[] =  $resultCat['total'];
            }

            $datasets[] = [
                'label' => $cat,
                'backgroundColor' => $color[$index],
                'data' => $totalAll
            ];
        }


        $this->dataBlock = [
            'labels' => $label,
            'datasets' => $datasets
        ];

        //monthly
        $monthly = $result['monthly'];
        $label = [];
        $datasets = [];
        foreach ($monthly as $index => $list) {
            $label[] = $list['month'];
            $datasets[] = $list['total'];
        }

        $this->dataLine = [
            'labels' => $label,
            'datasets' => $datasets
        ];
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.production-ytd-chart');
    }
}
