<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Ds;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->documentSystemApi($result);
    }
    
    protected $listeners = ['documentSystemApi'];
    public function documentSystemApi($result)
    {
        try {
            $result = $result['ytd'];

            $actual = $result['target'];
            $progress = $result['actual'] && $result['target'] ? $result['actual'] / $result['target'] * 100  : 0;
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
        return view('livewire.main-dashboard.public.widgets.ds.summary');
    }
}
