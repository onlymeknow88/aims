<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Fls;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->fieldLeadershipApi($result);
    }
    
    protected $listeners = ['fieldLeadershipApi'];
    public function fieldLeadershipApi($result)
    {
        try {
            $result = $result['ytd'];
            
            $actual = $result['target'];
            $progress = $result['actual'] && $result['target'] ? $result['actual'] / $result['target'] * 100 : 0;
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
        return view('livewire.main-dashboard.public.widgets.fls.summary');
    }
}
