<?php

namespace Modules\Audit\Http\Livewire\Iso9001\CriteriaAudit;

use App\Enums\Pica\PicaStatus;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use Modules\Pica\Entities\PicaDocument;
use App\Enums\PicaSource;
use Illuminate\Support\Facades\DB;

class Detail extends Component
{
    public AuditSubCriteria|null $auditSubCriteria;
    public $teams = [];

    public Audit $audit;

    public $point;
    public $max;
    public string|null $status;
    public string|null $tooltip;
    public string|null $description = "";
    public string|null $system_references = "";
    public string|null $current_system_verification = "";
    public bool|null $isConfirm;
    public bool|null $isRelation;
    public mixed $fix_recommendation;

    public $non_confirmance_number = null;
    public $problem_description = null;
    public $area_location_department = null;
    public $proof = null;
    public $non_confirmance_description = null;
    public $category = null;
    public $due_date = null;
    public $audit_team_id = null;
    public $auditor_date = null;
    public $auditee = null;
    public $auditee_date = null;
    public $root_cause_investigation = null;
    public $fix_action = null;


    public function mount($criteria_id)
    {
        $this->getAudit($criteria_id);
    }

    public function hydrate(): void
    {

        $this->emit('select2');
        $this->emit('summernote');
    }

    public function resetForm()
    {
        $this->resetExcept('auditSubCriteria', 'audit');
    }

    public function updated($name, $value)
    {

        if ($name == 'point') {
            $this->tooltip = $this->auditSubCriteria->list_points->where('point', $value)->first()?->tooltip;
            $this->status = null;
            $this->isConfirm = null;
            $this->isRelation = null;

            if (strlen($value) > 0) {

                if (intval($value) >= $this->auditSubCriteria->target_point) {
                    $this->status = 'confirmance';
                } else if(intval($value) == 1) {
                    $this->status = 'non confirmance';
                }else{
                    $this->status = 'non relation';
                }
            }

            if ($this->auditSubCriteria->status) {
                if ($this->auditSubCriteria->status == $this->status) {
                    $this->isConfirm = $this->status == 'confirmance';
                }
            }

        }
    }

    protected function getAudit($criteria_id): void
    {
        $this->isConfirm = null;
        $this->isRelation = null;

        $this->status = null;
        $this->auditSubCriteria = AuditSubCriteria::with('children.list_points', 'list_points', 'criteria.module', 'sample_methods', 'confirmance', 'non_confirmance')->findOrFail($criteria_id);
        $this->audit = Audit::with(['criteria_module.criteria.sub_criteria.children.sample_methods'])->findOrFail($this->auditSubCriteria->criteria->module->audit_id);
        $this->max = $this->auditSubCriteria->max_point;
        $this->point = $this->auditSubCriteria->point;
        $this->description = $this->auditSubCriteria->description;
        $this->system_references = $this->auditSubCriteria->system_references;
        $this->current_system_verification = $this->auditSubCriteria->current_system_verification;
        $this->fix_recommendation = $this->auditSubCriteria->confirmance?->fix_recommendation;
        $this->non_confirmance_number = $this->auditSubCriteria->non_confirmance?->non_confirmance_number;
        $this->problem_description = $this->auditSubCriteria->non_confirmance?->problem_description;
        $this->area_location_department = $this->auditSubCriteria->non_confirmance?->area_location_department;
        $this->proof = $this->auditSubCriteria->non_confirmance?->proof;
        $this->non_confirmance_description = $this->auditSubCriteria->non_confirmance?->non_confirmance_description;
        $this->category = $this->auditSubCriteria->non_confirmance?->category;
        $this->due_date = $this->auditSubCriteria->non_confirmance?->due_date;
        $this->audit_team_id = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->audit_team_id : $this->auditSubCriteria->confirmance?->audit_team_id;;
        $this->auditee = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditee : $this->auditSubCriteria->confirmance?->auditee;
        $this->auditee_date = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditee_date : $this->auditSubCriteria->confirmance?->auditee_date;
        $this->auditor_date =$this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditor_date : $this->auditSubCriteria->confirmance?->auditor_date;

        $this->root_cause_investigation = $this->auditSubCriteria->non_confirmance?->root_cause_investigation;
        $this->fix_action = $this->auditSubCriteria->non_confirmance?->fix_action;
        if ($this->auditSubCriteria->status == "confirmance") {
            $this->isConfirm = true;
            $this->isRelation = false;
        }else
        if ($this->auditSubCriteria->status == "non confirmance") {
            $this->isConfirm = false;
            $this->isRelation = false;
        }else
        if($this->auditSubCriteria->status == "non relation"){
            $this->isConfirm = false;
            $this->isRelation = true;
        }

        $this->teams = $this->audit->auditors()->get();

    }

    public function confirm()
    {
        $this->validate([
            'point' => 'required|numeric|min:0|max:' . $this->max,
            'status' => 'required|in:confirmance,non confirmance,non relation'
        ]);
        try {
            \DB::beginTransaction();
            $this->auditSubCriteria->point = intval($this->point);
            $this->auditSubCriteria->status = $this->status;
            $this->auditSubCriteria->description = $this->description;
            $this->auditSubCriteria->system_references = $this->system_references;
            $this->auditSubCriteria->current_system_verification = $this->current_system_verification;
            $this->auditSubCriteria->save();
            $this->getAudit($this->auditSubCriteria->id);
            \DB::commit();
            return redirect()->route('audit::iso9001.detail.criteria-audit.detail',['id'=>$this->audit->id,'criteria_id'=>$this->auditSubCriteria->id]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function save(): void
    {

        if ($this->auditSubCriteria->status == "confirmance") {
            $this->saveConfirmance();
            return;
        }

        if ($this->auditSubCriteria->status == "non confirmance") {
            $this->saveNonConfirmance();
            return;
        }

        if ($this->auditSubCriteria->status == "non relation") {
            $this->saveNonRelation();
            return;
        }
        return;
    }

    private function saveConfirmance(): void
    {
        $this->validate([
            'fix_recommendation' => 'nullable'
        ]);
        $confirmance = $this->auditSubCriteria->confirmance()->firstOrCreate();
        if (isset($this->fix_recommendation)) {
            $confirmance->fix_recommendation = $this->fix_recommendation;
        }

        $confirmance->audit_team_id = $this->audit_team_id;
        $confirmance->auditor_date = date('Y-m-d H:i:s',strtotime($this->auditor_date));
        $confirmance->auditee = $this->auditee;
        $confirmance->auditee_date = date('Y-m-d H:i:s',strtotime($this->auditee_date));

        $confirmance->save();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
    }

    private function saveNonConfirmance(): void
    {
        $validate = $this->validate([
            'problem_description' => 'nullable',
            'area_location_department' => 'nullable',
            'proof' => 'nullable',
            'non_confirmance_description' => 'nullable',
            'category' => 'nullable',
            'due_date' => 'nullable|date',
            'audit_team_id' => 'nullable',
            'auditor_date' => 'nullable|date',
            'auditee' => 'nullable',
            'auditee_date' => 'nullable|date',
            'root_cause_investigation' => 'nullable',
            'fix_action' => 'nullable',
        ]);

        $non_confirmance =  $this->auditSubCriteria->non_confirmance()->firstOrNew();
        $validate['due_date'] = Carbon::parse($validate['due_date']);
        $validate['auditor_date'] = Carbon::parse($validate['auditor_date']);
        $validate['auditee_date'] = Carbon::parse($validate['auditee_date']);
        $validate['status'] = PicaStatus::Open()->value;
        $non_confirmance->fill($validate);
        $non_confirmance->save();

        $picaDocument = PicaDocument::create([
            'source' => PicaSource::Audit,
            'type' => null,
            'date' => null,
            'ccow_id' => $this->audit->company->id,
            'company_id' => $this->audit->company->id,
            'section_id' => null,//$pica->form?->ibpr->section_id ?? $pica->formIadl->iadl->section_id,
            'location_id' => null,
            'location_detail' => null,
            'company_detail' => null,//$pica->form?->ibpr->ccow->company_name ?? $pica->formIadl->iadl->ccow->company_name ,
            'pja_id' => null,//$pica->form?->ibpr->pja->id ?? $pica->formIadl->iadl->pja->id,
            'pjo_id' => null,//$pica->form?->ibpr->pjo->id ?? $pica->formIadl->iadl->pjo->id,
            'auditor' => null,
            'non_compliance' => null,
            'non_compliance_root_cause' => null,
            'corrective_action' => null,
            'target_settlement_date' => Carbon::parse($non_confirmance->due_date)->format('Y-m-d'),
            'settlement_date' => Carbon::parse($non_confirmance->due_date)->format('Y-m-d'),
            'remarks' => null,
            'status' => PicaStatus::Open()->value
        ]);

        $picaDocument->pica()->create([
            'source' => PicaSource::Audit,
            'source_id' => $non_confirmance->id,
            'picaable_id' => $picaDocument->id,
            'picaable_type' => AuditCriteriaNonConfirmance::class,
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
    }

    private function saveNonRelation():void
    {

        try {
            \DB::beginTransaction();
            $this->auditSubCriteria->point = intval($this->point);
            // $this->auditSubCriteria->status = $this->status;
            $this->auditSubCriteria->description = $this->description;
            $this->auditSubCriteria->system_references = $this->system_references;
            $this->auditSubCriteria->current_system_verification = $this->current_system_verification;
            $this->auditSubCriteria->save();
            $this->getAudit($this->auditSubCriteria->id);
            \DB::commit();
            // return redirect()->route('audit::iso45001.detail.criteria-audit.detail',['id'=>$this->audit->id,'criteria_id'=>$this->auditSubCriteria->id]);
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function render()
    {
        return view('audit::livewire.criteria-audit.detail',[
            'module_category'=>'iso9001'
        ])->layout('audit::livewire.layouts.app');
    }
}
