<?php

namespace Modules\Audit\Http\Livewire\Smkp\MethodAndSample;

use Livewire\Component;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

class Detail extends Component
{

    public AuditSubCriteria|null $auditSubCriteria;
    public $available_sub_criteria;
    public $sample;
    public $modalType = 'create';

    public $availableMethods = [];

    public $audit_method_id;

    public Audit|null $audit;

    public function mount($criteria_id)
    {
        $this->getAudit($criteria_id);
    }

    protected function getAudit($criteria_id): void
    {
        $this->auditSubCriteria = AuditSubCriteria::with('children.list_points', 'list_points', 'criteria.module', 'sample_methods')->findOrFail($criteria_id);
        $this->audit = Audit::with(['criteria_module.criteria.sub_criteria.children.sample_methods'])->findOrFail($this->auditSubCriteria->criteria->module->audit_id);
        $this->availableMethods = AuditMethod::all();
        $this->available_sub_criteria = AuditSubCriteria::doesntHave('children')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', false)->pluck('title', 'id');

    }

    public function showModalCreate()
    {
        $this->availableMethods = AuditMethod::whereDoesntHave('sub_criteria', function ($sub) {
            $sub->where('audit_sub_criteria.id', $this->auditSubCriteria->id);
        })->get();
        $this->dispatchBrowserEvent('showModal');

    }

    public function hydrate(): void
    {

        $this->emit('select2');
    }

    public function save(): void
    {
        $this->validate([
            'audit_method_id' => 'required|exists:audit_methods,id',
            'sample' => 'required'
        ]);
        $check = AuditMethod::whereDoesntHave('sub_criteria', function ($sub) {
            $sub->where('audit_sub_criteria.id', $this->auditSubCriteria->id);
        })->where('id', $this->audit_method_id)->first();
        if (!$check) {
            $this->addError("audit_method_id", "Metode ini sudah ada");
            return;
        }
        $this->auditSubCriteria->sample_methods()->attach($this->audit_method_id, [
            'sample' => $this->sample
        ]);
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
        $this->dispatchBrowserEvent('closeModal');
        $this->getAudit($this->auditSubCriteria->id);
        $this->dispatchBrowserEvent('summerNote');

    }

    public function render()
    {
        return view('audit::livewire.smkp.method-and-sample.detail')->layout('audit::livewire.layouts.app');
    }
}
