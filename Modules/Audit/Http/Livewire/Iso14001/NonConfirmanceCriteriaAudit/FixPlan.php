<?php

namespace Modules\Audit\Http\Livewire\Iso14001\NonConfirmanceCriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Fixplan extends Component
{

    public $audit;
    public $non_confirmance;
    public  int $startNumber = 0;

    public function mount($id)
    {
        $this->audit = Audit::with('company')
            ->with('auditors')
            ->find($id);

        $this->getNonConfirmanceByAudit($id);

    }

    protected function getNonConfirmanceByAudit($id): void
    {

        $this->non_confirmances = AuditCriteriaNonConfirmance::with('audit_sub_criteria.criteria.module.audit.company')
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();



        // dd($this->non_confirmances);
    }

    public function generatePDF($id){

        $this->mount($id);

        $auditors = $this->audit->auditors;

        $lead_auditor = "";
        foreach ($auditors as $key => $value) {
            if($value->audit_team_role_id == 1){
                $lead_auditor = $value;
            }
        }


        $pdfContent = PDF::loadview('audit::livewire.non-conformance-criteria-audit.fix-plan-export',
        [
            'audit_category'=>'iso14001',
            "non_confirmances"=>$this->non_confirmances,
            "audit"=>$this->audit,
            "startNumber"=>0,
            "lead_auditor"=>$lead_auditor
        ])->setPaper('a4', 'landscape');

        return $pdfContent->download($this->audit->title.'-non-confirmance.pdf');

    }

    public function generateWord($id)
    {
        $this->mount($id);

        $auditors = $this->audit->auditors;

        $lead_auditor = "";
        foreach ($auditors as $key => $value) {
            if($value->audit_team_role_id == 1){
                $lead_auditor = $value;
            }
        }

        $viewContent = view('audit::livewire.non-conformance-criteria-audit.fix-plan-export-word', [
            'audit_category'=>'smkp',
            "non_confirmances"=>$this->non_confirmances,
            "audit"=>$this->audit,
            "startNumber"=>0,
            "lead_auditor"=>$lead_auditor
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-non-conformance-fix.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-non-conformance-fix.docx'))->deleteFileAfterSend(true);
    }

    public function render()
    {

        return view('audit::livewire.non-conformance-criteria-audit.fix-plan',
        [
            'category'=>'iso14001'
        ])->layout('audit::livewire.layouts.app');
    }
}
