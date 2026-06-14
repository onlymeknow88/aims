<?php

namespace Modules\CSMS\Http\Livewire\Dashboard\Widgets;

use Livewire\Component;

class Summary extends Component
{
    public $data = [
        'count' => null,
        'progress' => null
    ];

    public function mount($result)
    {
        $this->csmsApi($result);
    }

    protected $listeners = ['csmsApi'];
    public function csmsApi($result)
    {
        try {
            $result = $result['yearly'];
            $this->data = [
                'count' => $result['ytd'],
                'progress' => $result['percent']
            ];
        } catch (\exception $e) {
        }
    }

    public function render()
    {
        return view('csms::livewire.dashboard.widgets.summary');
    }
}
