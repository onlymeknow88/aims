<?php

namespace App\Http\Livewire\Demo\Chart;

use Livewire\Component;

class Chart extends Component
{
    public $barChart = [];
    public $lineChart = [];
    public $pieChart = [];
    public $doughnutChart = [];

    public function mount(){
        
        $this->barChart = [
            'idChart'   =>  'barChart',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Bar Chart',
                'backgroundColor'   => '#009D50',
                'hoverBackgroundColor'  => '#D9DC30',
                'data'  =>  [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56]
            ]],
            'labelX'    => [
                'display'       => true,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        $this->lineChart = [
            'idChart'   =>  'lineChart',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Line Chart',
                'backgroundColor'   => '#009D50',
                'hoverBackgroundColor'  => '#D9DC30',
                'data'  =>  [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56]
            ]],
            'labelX'    => [
                'display'       => true,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        $this->pieChart = [
            'idChart'   =>  'pieChart',
            'width'     => 300,
            'height'    => 300,
            'labels'    =>  ['Roti', 'Telo', 'Es Teh', 'Udang'],
            'datasets'  =>  [[
                'label' => 'Pie Chart',
                'data'  =>  [65, 59, 20, 81, 56],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                ],
            ]],
            'legend'    => true,
            'labelX'    => [
                'display'       => false,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        $this->doughnutChart = [
            'idChart'   =>  'doughnutChart',
            'width'     => 300,
            'height'    => 300,
            'labels'    =>  ['Roti', 'Telo', 'Es Teh', 'Udang'],
            'datasets'  =>  [[
                'label' => 'Pie Chart',
                'data'  =>  [65, 59, 20, 81, 56],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                ],
            ]],
            'legend'    => true,
            'labelX'    => [
                'display'       => false,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

    }
    public function render()
    {
        return view('livewire.demo.chart.chart');
    }
}
