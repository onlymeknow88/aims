<?php

namespace App\Http\Livewire\Audit\Smkp;

use Livewire\Component;

class Grafik extends Component
{
    public $radarChart = [];

    public function mount(){
        $this->radarChart = [
            'idChart'   =>  'grafikChart',
            'labels'    =>  [
                'Kebijakan', 
                'Perencanaan', 
                'Organisasi dan Personel', 
                'Implementasi', 
                'Pemantauan, Evaluasi, dan Tindak Lanjut', 
                'Dokumentasi', 
                'Tijuaan Manajemen dan Peningkatan Kinerja'
            ],
            'datasets'  =>  [[
                'label'                     => 'Poin SMKP',
                'fill'                      => true,
                'backgroundColor'           => 'rgba(54, 162, 235, 0.2)',
                'borderColor'               => 'rgb(54, 162, 235)',
                'pointBackgroundColor'      => 'rgb(54, 162, 235)',
                'pointBorderColor'          => '#fff',
                'pointHoverBackgroundColor' => '#fff',
                'pointHoverBorderColor'     => 'rgb(54, 162, 235)',
                'data'                      =>  [-65, 59, 50, 81, 56, 55, 40]
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
        return view('livewire.audit.smkp.grafik');
    }
}
