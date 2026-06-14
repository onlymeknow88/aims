<?php

namespace Modules\Audit\Http\Livewire\Layouts;

use Livewire\Component;
use Modules\Audit\Entities\Audit;

class SidebarSmkp extends Component
{
    public ?Audit $smkp;
    public ?bool $pass = null;
    public function mount($id)
    {
        $this->id = $id;
        $this->smkp = Audit::findOrFail($id);
    }

    public function render()
    {
        return view('audit::livewire.layouts.sidebar-smkp',['id'=>$this->id]);
    }
}
