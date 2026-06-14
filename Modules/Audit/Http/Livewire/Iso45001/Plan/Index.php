<?php

namespace Modules\Audit\Http\Livewire\Iso45001\Plan;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

class Index extends Component
{
    public Audit|null $audit;
    public $criteria = [];
    public $exceptions = [];
    public $progress;

    public mixed $company_name;
    public string $audit_type;
    public string|null $audit_criteria_reference = null;
    public string|null $audit_scope = null;
    public string|null $address = null;
    public string|null $site_address = null;
    public string|null $purpose = null;
    public string|null $relevant_document = null;
    public string|null $facility = null;
    public string|null $audit_date = null;

    public string|null $reporting_distribution = null;

    public function mount($id)
    {
        $this->getAudit($id);

      
    }

    protected function getAudit($id): void
    {
        $this->audit = Audit::with('criteria_module.criteria.sub_criteria.children', 'audit_plan.detail', 'auditors')->findOrFail($id);
        $this->company_name = $this->audit->company->company_name;
        $this->audit_type = $this->audit->audit_type . ' ' . $this->audit->title;
        $this->criteria = AuditSubCriteria::whereHas('criteria', function ($criteria) {
            $criteria->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->whereDoesntHave('children')->pluck('title', 'id');
        $this->exceptions = AuditSubCriteria::whereHas('criteria', function ($criteria) {
            $criteria->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', true)->pluck('id')->toArray();
        $this->audit_date = Carbon::parse($this->audit->start_at)->format('d M Y') . " - " . Carbon::parse($this->audit->end_at)->format('d M Y');
        $this->audit_criteria_reference = $this->audit->audit_plan->detail->audit_criteria_reference;
        $this->address = $this->audit->audit_plan->detail->address;
        $this->site_address = $this->audit->audit_plan->detail->site_address;
        $this->purpose = $this->audit->audit_plan->detail->purpose;
        $this->audit_scope = $this->audit->audit_plan->detail->audit_scope;
        $this->relevant_document = $this->audit->audit_plan->detail->relevant_document;
        $this->facility = $this->audit->audit_plan->detail->facility;
        $this->reporting_distribution = $this->audit->audit_plan->detail->reporting_distribution;

        $this->progress = formProgress([
            "audit_criteria_reference",
            "address",
            "site_address",
            "purpose",
            "audit_scope",
            "relevant_document",
            "facility",
            "reporting_distribution"
        ],[
            "audit_criteria_reference"=>$this->audit_criteria_reference,
            "address"=>$this->address,
            "site_address"=>$this->site_address,
            "purpose"=>$this->purpose,
            "audit_scope"=>$this->audit_scope,
            "relevant_document"=>$this->relevant_document,
            "facility"=>$this->facility,
            "reporting_distribution"=>$this->reporting_distribution,
        ]);

//        dd($this);

    }

    public function save()
    {
        $data = $this->validate([
            'audit_scope' => 'nullable',
            'audit_criteria_reference' => 'nullable',
            'purpose' => 'nullable',
            'address' => 'nullable',
            'site_address' => 'nullable',
            'relevant_document' => 'nullable',
            'facility' => 'nullable',
            'reporting_distribution' => 'nullable',
            'exceptions' => 'nullable'
        ]);
        try {
            \DB::beginTransaction();
            $this->audit->audit_plan->detail()->update(collect($data)->except(['exceptions'])->toArray());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            AuditSubCriteria::whereHas('criteria', function ($criteria) {
                $criteria->where('audit_criteria_module_id', $this->audit->criteria_module->id);
            })->whereIn('id', $this->exceptions)->update(['excluded' => true]);

            \DB::commit();
            $this->getAudit($this->audit->id);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => 'Data gagal disimpan'
            ]);
        }
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Audit Plan')) {
            return view('audit::livewire.plan.index',
            [
                'category'=>'iso45001'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }
}
