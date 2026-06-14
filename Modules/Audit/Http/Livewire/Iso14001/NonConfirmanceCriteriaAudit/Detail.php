<?php

namespace Modules\Audit\Http\Livewire\Iso14001\NonConfirmanceCriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use PDF;

class Detail extends Component
{

    public $audit;
    public $non_conformance;

    public function mount($id,$non_conformance_id)
    {
        $this->audit = Audit::with('company')->find($id);

        $this->getNonConfirmanceById($non_conformance_id);
        
    }

    protected function getNonConfirmanceById($id): void
    {
        $this->non_conformance = AuditCriteriaNonConfirmance::with('audit_sub_criteria.criteria')->find($id);
        
    }

    public function render()
    {

        return view('audit::livewire.non-conformance-criteria-audit.detail',
        [
            'category'=>'iso14001'
        ])->layout('audit::livewire.layouts.app');
    }

    public function exportFixPDF($id,$non_confirmance_id){
        $this->mount($id,$non_confirmance_id);

        $auditors = $this->audit->auditors;
        $lead_auditor = "";
        foreach ($auditors as $key => $value) {
            if($value->audit_team_role_id == 1){
                $lead_auditor = $value;
            }
        }

        $pdfContent = PDF::loadview('audit::livewire.non-conformance-criteria-audit.detail-fix-export',[
            'category'=>'iso14001',
            'audit'=>$this->audit,
            'non_conformance' => $this->non_conformance,
            'lead_auditor'=>$lead_auditor,
        ]);

        return $pdfContent->download($this->audit->title.'-non-confirmance.detail.fix.pdf');

    }

    public function generatePDF($id,$non_conformance_id){
        $this->mount($id,$non_conformance_id);

        $auditors = $this->audit->auditors;
        $lead_auditor = "";
        foreach ($auditors as $key => $value) {
            if($value->audit_team_role_id == 1){
                $lead_auditor = $value;
            }
        }

        $pdfContent = PDF::loadview('audit::livewire.non-conformance-criteria-audit.detail-export',[
            'category'=>'iso14001',
            'audit'=>$this->audit,
            'non_conformance' => $this->non_conformance,
            'lead_auditor'=>$lead_auditor,
        ]);

        return $pdfContent->download($this->audit->title.'-non-confirmance.detail.pdf');
    }
}