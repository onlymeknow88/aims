<?php

namespace Modules\Audit\Http\Livewire\Layouts;

use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

class SidebarSmkpSample extends Component
{
    public Audit $smkp;
    public $selected;
    public $activeSidebar = [];

    /**
     * @param Audit $smkp
     * @return void
     */
    public function mount(Audit $smkp, $selected)
    {
        $this->smkp = $smkp;
        $this->selected = $selected;
        $check = AuditSubCriteria::doesntHave('children')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->smkp->criteria_module->id);
        })->where('excluded', false)->where('id', $selected)->firstOrFail();
        $this->activeSidebar[] = $selected;
        if ($check->parent_id != null) {
            $this->activeSidebar[] = $check->parent_id;
        }
        $this->activeSidebar[] = $check->audit_criteria_id;
    }

    public function render()
    {
        return view('audit::livewire.layouts.sidebar-smkp-sample');
    }
}
