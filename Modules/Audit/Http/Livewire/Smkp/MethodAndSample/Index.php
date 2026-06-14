<?php

namespace Modules\Audit\Http\Livewire\Smkp\MethodAndSample;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;

class Index extends Component

{

    public Audit|null $audit;
    public $availableMethods = [];
    public AuditCriteriaModule|null $moduleCriteria;

    public  $available_sub_criteria = [];

    public $progress = 0;

    public function mount($id)
    {
        $this->getAudit($id);
    }

    protected function getAudit($id): void
    {
        $this->audit = Audit::with(['criteria_module.criteria.sub_criteria.children.sample_methods'])->findOrFail($id);
        $this->availableMethods = AuditMethod::all();
        $this->available_sub_criteria = AuditSubCriteria::doesntHave('children')->with('sample_methods')->whereHas('criteria', function ($q) { //
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', false)->get();//->pluck('title', 'id');

        $ref_num = count($this->available_sub_criteria->toArray());
        $score = 0;

        foreach ($this->available_sub_criteria->toArray() as $value) {
            if(!empty($value["sample_methods"])){
                
                $score++;
            }
        }

        if($ref_num > 0){

            $this->progress = round(($score/$ref_num)*100,2);
        }

        
    }

    public function goTo($criteria_id)
    {
        $check = AuditSubCriteria::doesntHave('children')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', false)->where('id', $criteria_id)->first();
        if (!$check) {
            return false;
        }
        return redirect()->route('audit::smkp.detail.method-and-sample.detail', ['id' => $this->audit->id, 'criteria_id' => $criteria_id]);
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Method and Sample')) {
            return view('audit::livewire.smkp.method-and-sample.index')->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }
}
