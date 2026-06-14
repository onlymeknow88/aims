<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets\Audit;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->auditApi($result);
    }
    
    protected $listeners = ['auditApi'];
    public function auditApi($result)
    {
        try {
            $result = $result['ytd'];

            $actual = $result['actual'];
            $progress = $result['actual'] != 0 && $result['target'] != 0 ? $result['actual'] / $result['target'] * 100 : 0;
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
        return view('livewire.main-dashboard.public.widgets.audit.summary');
    }
}
