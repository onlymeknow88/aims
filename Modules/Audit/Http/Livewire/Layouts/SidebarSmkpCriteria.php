<?php

namespace Modules\Audit\Http\Livewire\Layouts;

use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

class SidebarSmkpCriteria extends Component
{
    public Audit $audit;
    public $selected;
    public $activeSidebar = [];

    /**
     * @param Audit $smkp
     * @return void
     */
    public function mount(Audit $audit, $selected)
    {
        $this->audit = $audit;
        $this->selected = $selected;
        $check = AuditSubCriteria::doesntHave('children')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', false)->where('id', $selected)->firstOrFail();
        $this->activeSidebar[] = $selected;
        if ($check->parent_id != null) {
            $this->activeSidebar[] = $check->parent_id;
        }
        $this->activeSidebar[] = $check->audit_criteria_id;
    }

    public function render()
    {
        return view('audit::livewire.layouts.sidebar-smkp-criteria');
    }
}
