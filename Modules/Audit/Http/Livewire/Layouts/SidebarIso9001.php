<?php

namespace Modules\Audit\Http\Livewire\Layouts;

use Livewire\Component;
use Modules\Audit\Entities\Audit;

class SidebarIso9001 extends Component
{
    public ?Audit $audit;
    public ?bool $pass = null;
    public function mount($id)
    {
        $this->id = $id;
        $this->audit = Audit::findOrFail($id);
    }

    public function render()
    {
        return view('audit::livewire.layouts.sidebar-iso9001',['id'=>$this->id]);
    }
}
