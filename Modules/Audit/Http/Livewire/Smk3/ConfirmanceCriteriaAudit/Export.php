<?php

namespace Modules\Audit\Http\Livewire\Smk3\ConfirmanceCriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaConfirmance;
use PDF;

class Export extends Component
{
    public $audit;
    public $confirmances = [];
    public $description = [];

    public function mount($id)
    {

        $this->getConfirmanceByAudit($id);

    }

    protected function getConfirmanceByAudit($id): void
    {


        $this->audit = Audit::with('company')->find($id);

        $this->confirmances = AuditCriteriaConfirmance::with('audit_sub_criteria.criteria.module.audit')
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();

        foreach ($this->confirmances as $key => $value) {

            $this->description[$value->audit_sub_criteria->id] = $value->audit_sub_criteria->description;
        }
        // dd($this->confirmances);
    }

    public function generatePDF($id){

        $this->audit = Audit::with('company')->find($id);

        $this->confirmances = AuditCriteriaConfirmance::with('audit_sub_criteria.criteria.module.audit')
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();


        $pdfContent = PDF::loadview('audit::livewire.smkp.confirmance-criteria-audit.export',
            ["confirmances"=>$this->confirmances,
            "audit"=>$this->audit]);
        return $pdfContent->download('criteria-confirmance.pdf');

    }

    public function render()
    {

        $pdfContent = PDF::loadview('audit::livewire.smkp.confirmance-criteria-audit.export',
            ["confirmances"=>$this->confirmances,
            "audit"=>$this->audit])->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "criteria-confirmance.pdf"
           );
    	// return $pdf->download('criteria-confirmance.pdf');


        // return view('audit::livewire.smkp.confirmance-criteria-audit.export')->layout('audit::livewire.layouts.app');
    }
}
