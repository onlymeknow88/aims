<?php

namespace Modules\Sap\Http\Livewire\Home\Sidebar;

use Livewire\Component;
use Modules\Sap\Entities\SapSetupCategory;

class SidebarLeft extends Component
{
    public $sidebar_left;
    protected $listeners = ['setupUpdate' => 'render'];

    public function render()
    {

        $data = SapSetupCategory::where('available', 'true')->first();
        $this->sidebar_left = $data ? $data->setupList : [];

        return view('sap::livewire.home.sidebar.sidebar-left');
    }
}
