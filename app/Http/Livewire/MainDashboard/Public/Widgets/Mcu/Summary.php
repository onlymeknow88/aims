<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Mcu;

use Livewire\Component;
use App\Access\ApiModules;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->mcuApi($result);
    }
    
    protected $listeners = ['mcuApi'];
    public function mcuApi($result)
    {
        try {
            $result = $result['count_ytd'];

            $actual = $result['ytd'];
            $progress =  $result['ytd'] && $result['ytd_target'] ?  $result['ytd'] / $result['ytd_target']  * 100 : 0;
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
        if (!is_array($this->data)) {
            return view('livewire.main-dashboard.public.error-small');
        }
        return view('livewire.main-dashboard.public.widgets.mcu.summary');
    }
}
