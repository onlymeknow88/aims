<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Cr;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->complianceRegulationApi($result);
    }
    
    protected $listeners = ['complianceRegulationApi'];
    public function complianceRegulationApi($result)
    {
        try {
            $result = $result['ytd'];
            
            $actual =  $result['ytd'];
            $progress =  $result['ytd'] != 0  && $result['ytd_target'] != 0 ?  $result['ytd'] / $result['ytd_target'] * 100 : 0;
            $progress = round($progress, 2);

            $this->data = [
                'count' => $actual,
                'progress' => $progress
            ];
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.cr.summary');
    }
}
