<?php

namespace App\Http\Livewire\DocumentSystems;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DashboardDocummentSystems extends Component
{
    use AuthorizesRequests;

    public $dataChart1 = [];
    public $dataChart2 = [];
    public $dataChart3 = [];
    public $dataChart4 = [];
    public $dataChart5 = [];
    public $dataChart6 = [];

    public function mount(){

        $this->dataChart1 = [
            'idChart'   =>  'chart1',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Mining & Engineering',
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
        $this->dataChart2 = [
            'idChart'   =>  'chart2',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'CPP Operation',
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
        $this->dataChart3 = [
            'idChart'   =>  'chart3',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Maintenance',
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
        $this->dataChart4 = [
            'idChart'   =>  'chart4',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Logistic',
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
        $this->dataChart5 = [
            'idChart'   =>  'chart5',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Procurement',
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
        $this->dataChart6 = [
            'idChart'   =>  'chart6',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Explorasi',
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
        $this->dataChart7 = [
            'idChart'   =>  'chart7',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'External & Relation',
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
        $this->dataChart8 = [
            'idChart'   =>  'chart8',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'Port Operation & Maintena...',
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
        $this->dataChart9 = [
            'idChart'   =>  'chart9',
            'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets'  =>  [[
                'label' => 'IT',
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

    }

    public function render()
    {
        return view('livewire.document-systems.dashboard-documment-systems');
    }
}
