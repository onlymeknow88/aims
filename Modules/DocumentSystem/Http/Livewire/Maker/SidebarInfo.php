<?php

namespace Modules\DocumentSystem\Http\Livewire\Maker;

use Livewire\Component;

class SidebarInfo extends Component
{
    public function render()
    {
        return view('documentsystem::livewire.maker.sidebar-info')->layout('documentsystem::layouts.app');
    }
}
