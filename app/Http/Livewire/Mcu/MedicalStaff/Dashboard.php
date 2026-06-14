<?php

namespace App\Http\Livewire\Mcu\MedicalStaff;

use Livewire\Component;

class Dashboard extends Component
{
    public $cartBar1 = [];
    public $cartBar2 = [];
    public $cartBar3 = [];
    public $cartBar4 = [];

    public $pieChart = [];

    public function mount()
    {
        $this->cartBar1 = [
            'idChart' => 'chart1',
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#D9DC30',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $this->cartBar2 = [
            'idChart' => 'chart2',
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
                [
                    'label' => 'Perfor',
                    'backgroundColor' => '#D9DC30',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $this->cartBar3 = [
            'idChart' => 'chart3',
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#D9DC30',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $this->cartBar4 = [
            'idChart' => 'chart4',
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
                [
                    'label' => 'Perfor',
                    'backgroundColor' => '#D9DC30',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $this->pieChart = [
            'idChart' => 'pieChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Roti', 'Telo', 'Es Teh', 'Udang'],
            'datasets' => [
                [
                    'label' => 'Pie Chart',
                    'data' => [65, 59, 20, 81, 56],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                ],
            ],
            'legend' => true,
            'labelX' => [
                'display' => false,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.mcu.medical-staff.dashboard');
    }
}
