<?php

namespace Modules\Audit\Http\Livewire\Iso9001\NonConfirmanceCriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Index extends Component
{

    public $audit;
    public $non_confirmances = [];
    public $categories = [];
    public  int $startNumber = 0;

    public function mount($id)
    {

        $this->audit = Audit::with('company')->with('auditors')->find($id);

        $this->getNonConfirmanceByAudit($id);

    }

    protected function getNonConfirmanceByAudit($id): void
    {

        $this->non_confirmances = AuditCriteriaNonConfirmance::with('audit_sub_criteria.criteria.module.audit.company')
            ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
                $query->where('id', $id);
            })
            ->get();

        $this->categories = AuditCriteriaNonConfirmance::groupBy('category')->selectRaw('count(*) as total, category')
            ->orderBy('category','asc')
            ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
                $query->where('id', $id);
            })
            ->pluck('total','category')->all();

        if(!array_key_exists("critical",$this->categories)){
            $this->categories["critical"] = 0;
        }

        if(!array_key_exists("mayor",$this->categories)){
            $this->categories["mayor"] = 0;
        }

        if(!array_key_exists("minor",$this->categories)){
            $this->categories["minor"] = 0;
        }


        // dd($this->categories);
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
        // dd($this->smkp->auditors);

        $pdfContent = PDF::loadview('audit::livewire.non-conformance-criteria-audit.export',
            [
            'category'=>'iso9001',
            "non_confirmances"=>$this->non_confirmances,
            "categories"=>$this->categories,
            "audit"=>$this->audit,
            "lead_auditor"=>$lead_auditor,
            "startNumber"=>0])->setPaper('a4', 'landscape');

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

        $viewContent = view('audit::livewire.non-conformance-criteria-audit.export-word', [
            'category'=>'smkp',
            "non_confirmances"=>$this->non_confirmances,
            "categories"=>$this->categories,
            "audit"=>$this->audit,
            "lead_auditor"=>$lead_auditor,
            "startNumber"=>0
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-non-conformance.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-non-conformance.docx'))->deleteFileAfterSend(true);
    }

    public function render()
    {

        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Criteria Audit Non Confirmance')) {
            return view('audit::livewire.non-conformance-criteria-audit.index',
            [
                'category'=>'iso9001'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

    }
}
