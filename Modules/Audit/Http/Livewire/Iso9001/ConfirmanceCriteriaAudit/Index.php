<?php

namespace Modules\Audit\Http\Livewire\Iso9001\ConfirmanceCriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaConfirmance;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Index extends Component
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

        $this->confirmances = AuditCriteriaConfirmance::with(['audit_sub_criteria.criteria.module.audit','audit_sub_criteria.parent.parent'])
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();

        foreach ($this->confirmances as $key => $value) {

            $this->description[$value->audit_sub_criteria->id] = $value->audit_sub_criteria->description;
        }
        // dd($this->confirmances);
    }

    public function save(): void
    {
        \DB::beginTransaction();

        foreach($this->description as $key=>$val){

            $auditSubCriteria = AuditSubCriteria::find($key);
            $auditSubCriteria->update([
                "description"=>$val
            ]);

        }

        \DB::commit();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
    }


    public function render()
    {
        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Criteria Audit Confirmance')) {
            return view('audit::livewire.confirmance-criteria-audit.index',
            [
                'category'=>'iso9001'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }


    }

    public function generatePDF($id){

        $this->audit = Audit::with('company')->find($id);

        $this->confirmances = AuditCriteriaConfirmance::with('audit_sub_criteria.criteria.module.audit')
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();


        $pdfContent = PDF::loadview('audit::livewire.confirmance-criteria-audit.export',
        [
            'audit_category'=>'iso9001',
            "confirmances"=>$this->confirmances,
            "audit"=>$this->audit
        ]);
        return $pdfContent->download($this->audit->title.'-conformance.pdf');

    }

    public function generateWord($id)
    {
        $this->audit = Audit::with('company','auditors')->find($id);
        $this->confirmances = AuditCriteriaConfirmance::with('audit_sub_criteria.criteria.module.audit','audit_team')
            ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
                $query->where('id', $id);
            })
            ->get();

        $viewContent = view('audit::livewire.confirmance-criteria-audit.export-word', [
            'audit_category'=>'SMKP',
            "confirmances"=>$this->confirmances,
            "audit"=>$this->audit
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-conformance.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-conformance.docx'))->deleteFileAfterSend(true);
    }
}
