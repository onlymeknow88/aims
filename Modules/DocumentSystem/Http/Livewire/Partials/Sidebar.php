<?php

namespace Modules\DocumentSystem\Http\Livewire\Partials;

use Livewire\Component;

class Sidebar extends Component
{
    public bool $open = false;

    protected $listeners = ['toggleSidebar'];

    public function toggleSidebar()
    {
        $this->open = !$this->open;
    }

    public function render()
    {
        return view('documentsystem::layouts.partials.sidebar');
    }
}
