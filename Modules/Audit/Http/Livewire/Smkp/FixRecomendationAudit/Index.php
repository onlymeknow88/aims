<?php

namespace Modules\Audit\Http\Livewire\Smkp\FixRecomendationAudit;

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
    public $fix_recommendation = [];

    public function mount($id)
    {
        $this->getConfirmanceByAudit($id);

    }

    protected function getConfirmanceByAudit($id): void
    {

        $this->audit = Audit::with('company')->find($id);

        $this->confirmances = AuditCriteriaConfirmance::with(['audit_sub_criteria.criteria.module.audit.company','audit_sub_criteria.parent.parent'])
        ->whereHas("audit_sub_criteria.criteria.module.audit",function($query) use ($id){
            $query->where('id', $id);
        })
        ->get();

        foreach ($this->confirmances as $key => $value) {

            $this->fix_recommendation[$value->id] = $value->fix_recommendation;
        }
        // dd($this->fix_recommendation);
    }

    public function save(): void
    {
        \DB::beginTransaction();

        foreach($this->confirmances as $key=>$confirmance){

            $confirmance->fix_recommendation = $this->fix_recommendation[$confirmance->id];
            $confirmance->save();

        }

        \DB::commit();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
    }

    public function generatePDF($id){
        $this->mount($id);

        // dd($this->confirmances);
        $auditors = $this->audit->auditors;

        $pdfContent = PDF::loadview('audit::livewire.fix-recomendation-audit.export',
            [
                'audit_category'=>'smkp',
                "confirmances"=>$this->confirmances,
                "audit"=>$this->audit,
            ]);

        return $pdfContent->download($this->audit->title.'-fix-recomendation.pdf');
    }

    public function generateWord($id)
    {
        $this->mount($id);
        $auditors = $this->audit->auditors;

        $viewContent = view('audit::livewire.fix-recomendation-audit.export-word', [
            'audit_category'=>'smkp',
            "confirmances"=>$this->confirmances,
            "audit"=>$this->audit,
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-fix-recomendation.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-fix-recomendation.docx'))->deleteFileAfterSend(true);
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Audit Fix Recomendation')) {
            return view('audit::livewire.fix-recomendation-audit.index',[
                'category'=>'smkp'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

    }
}
