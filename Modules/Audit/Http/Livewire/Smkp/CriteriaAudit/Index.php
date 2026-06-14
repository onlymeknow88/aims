<?php

namespace Modules\Audit\Http\Livewire\Smkp\CriteriaAudit;

use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaModule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditCriteriaExport;
use App\imports\AuditCriteriaImport;

class Index extends Component
{
    public Audit | null $audit;
    public $availableMethods = [];
    public AuditCriteriaModule|null $moduleCriteria;

    public  $available_sub_criteria = [];
    public  $progress = 0;
    public $dataset = [];

    public function mount($id)
    {
        $this->getAudit($id);
        $this->getChartDataset();
    }

    protected function getAudit($id): void
    {
        $this->audit = Audit::with(['criteria_module.criteria.sub_criteria.children.sample_methods'])->findOrFail($id);
        $this->availableMethods = AuditMethod::all();
        $this->available_sub_criteria = AuditSubCriteria::doesntHave('children')->with('sample_methods')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);
        })->where('excluded', false)->get();//->pluck('title', 'id');



        $ref_num = count($this->available_sub_criteria->toArray());
        $score = 0;

        foreach ($this->available_sub_criteria->toArray() as $value) {
            if(!empty($value["status"])){

                $score++;
            }
        }

        if($ref_num > 0){

            $this->progress = round(($score/$ref_num)*100,2);
        }

    }

    public function getChartDataset()
    {
        $dataset = [];
        foreach($this->audit->criteria_module->criteria as $criteria){
            $criteria_max_point = 0;
            $criteria_point = 0;

            foreach($criteria->sub_criteria as $subCriteria) {

                $sub_criteria_max_point = 0;
                $sub_criteria_point = 0;

                if($subCriteria->children()->exists()) {
                    foreach($subCriteria->children as $subSubCriteria) {
                        $sub_sub_criteria_max_point = $subSubCriteria->target_point;
                        $sub_sub_criteria_point = $subSubCriteria->point;

                        $sub_criteria_max_point = $sub_criteria_max_point + $sub_sub_criteria_max_point;
                        $sub_criteria_point = $sub_criteria_point + $sub_sub_criteria_point;
                    }
                } else {
                    $sub_criteria_max_point = $subCriteria->target_point;
                    $sub_criteria_point = $subCriteria->point;
                }

                $criteria_max_point = $criteria_max_point + $sub_criteria_max_point;
                $criteria_point = $criteria_point + $sub_criteria_point;
            }
            $dataset[] = $criteria_max_point != 0
                ? round($criteria_point / $criteria_max_point * 100, 2)
                : 0;
        }

        $this->dataset = $dataset;
    }

    public function goTo($criteria_id)
    {
        $check = AuditSubCriteria::doesntHave('children')->whereHas('criteria', function ($q) {
            $q->where('audit_criteria_module_id', $this->audit->criteria_module->id);

        })->where('excluded', false)->where('id', $criteria_id)->first();
        if (!$check) {
            return false;
        }
        return redirect()->route('audit::smkp.detail.criteria-audit.detail', ['id' => $this->audit->id, 'criteria_id' => $criteria_id]);
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Criteria Audit')) {
            return view('audit::livewire.criteria-audit.index',
            [
                'category'=>'smkp'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

    }

    public function generateXLS($id){
        $this->mount($id);
        $array = Excel::toArray(new AuditCriteriaImport, storage_path('KriteriaAuditSMKP.xlsx'))[0];
        $audit_criteria = [];
        $criteria = $this->audit->criteria_module->criteria;

        foreach($criteria as $criterion ){
            $audit_criteria[] = ["","",$criterion->title,"10%","","","","","","","",""];
            foreach($criterion->sub_criteria as $sub_criterion){
                $audit_criteria[] = ["","",$sub_criterion->title,"","","","","",$sub_criterion->target_point,"",$sub_criterion->point,""];
                if(count($sub_criterion->children) > 0){

                    foreach ($sub_criterion->children as $children) {

                        $audit_criteria[] = ["","","",$children->title,"","","","","",$children->target_point,"",$children->point];
                    }
                    // dd($sub_criterion);
                }

            }

        }

        foreach($audit_criteria as $key => $value){
            // dd($value);
            if(!empty($value[8]))
                $array[$key+12][8] = $value[8];

            if(!empty($value[9]))
                $array[$key+12][9] = $value[9];

            if(!empty($value[10]))
                $array[$key+12][10] = $value[10];

            if(!empty($value[11]))
                $array[$key+12][11] = $value[11];
        }

        // dd($audit_criteria);


        $export = new AuditCriteriaExport($array);
        return Excel::download($export, 'audit-criteria.xlsx');

        // return Excel::download($export, 'audit-criteria.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

        // dd($array);

    }

    public function generatePDF($id){

    }

    public function export()
    {
        return Excel::download(new \App\Exports\Audit\AuditCriteriaExport($this->audit, $this->availableMethods, $this->available_sub_criteria), 'audit-criteria.xlsx');
    }
}
