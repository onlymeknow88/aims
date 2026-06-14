<?php

namespace Modules\Audit\Http\Livewire\Smkp\CriteriaAudit;

use App\Enums\Pica\PicaStatus;
use Carbon\Carbon;
use Livewire\Component;
use App\Enums\PicaSource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditSubCriteria;
use Modules\Audit\Entities\AuditSubCriteriaLocation;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use Modules\Audit\Entities\AuditLocation;
use Modules\Pica\Entities\PicaDocument;
use Illuminate\Support\Facades\DB;

class Detail extends Component
{
    public AuditSubCriteria| null $auditSubCriteria;
    public AuditSubCriteriaLocation| null $AuditSubCriteriaLocation;
    public $teams = [];

    public Audit $audit;

    public $point;
    public $max;
    public string|null $status;
    public string|null $tooltip;
    public string|null $description = "";
    public bool|null $isConfirm;
    public bool|null $isRelation;
    public mixed $fix_recommendation;

    public $non_confirmance_number = null;
    public $problem_description = null;
    public $area_location_department = null;
    public $proof = null;
    public $non_confirmance_description = null;
    public $category = null;
    public $category_uncheck = null;
    public $due_date = null;
    public $audit_team_id = null;
    public $auditor_date = null;
    public $auditee = null;
    public $auditee_date = null;
    public $root_cause_investigation = null;
    public $fix_action = null;
    public $critical = false;
    public $critical_done = false;


    public function mount($criteria_id)
    {
        $this->getAudit($criteria_id);
        // dd($this->category);
        $this->updated('category', $this->critical);
        $this->updated('critical_done', $this->critical_done);

        foreach ($this->Locations as $value) {
            $this->{'AuditSubCriteriaLocation_' . $value['id']} = AuditSubCriteriaLocation::where('audit_sub_criteria_id', $this->auditSubCriteria->id)->where('audit_location_id', $value->id)->first();

            $this->{'max_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->max : null;
            $this->{'tooltip_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->tooltip : null;
            $this->{'isConfirm_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->point : null;
            $this->{'isRelation_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->isConfirm : null;
            $this->{'category_uncheck_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->category_uncheck : null;

            $this->{'point_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->point : null;
            $this->{'description_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->description : null;
            $this->{'status_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->status : null;
            $this->{'is_critical_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? ($this->{'AuditSubCriteriaLocation_' . $value['id']}->is_critical == 1 ? true : false) : null;
            $this->{'is_critical_done_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? ($this->{'AuditSubCriteriaLocation_' . $value['id']}->is_critical_done == 1 ? true : false) : null;

            $this->{'fix_recommendation_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->fix_recommendation : null;
            $this->{'non_confirmance_number_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->non_confirmance_number : null;
            $this->{'problem_description_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->problem_description : null;
            $this->{'area_location_department_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->area_location_department : null;
            $this->{'proof_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->proof : null;
            $this->{'non_confirmance_description_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->non_confirmance_description : null;
            $this->{'category_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? ($this->{'AuditSubCriteriaLocation_' . $value['id']}->category == 1 ? true : false) : null;
            $this->updated('category', $this->{'category_' . $value['id']});

            $this->{'due_date_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->due_date : null;
            $this->{'audit_team_id_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->audit_team_id : null;
            $this->{'auditor_date_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->auditor_date : null;
            $this->{'auditee_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->auditee : null;
            $this->{'auditee_date_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->auditee_date : null;
            $this->{'root_cause_investigation_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->root_cause_investigation : null;
            $this->{'fix_action_' . $value['id']} = $this->{'AuditSubCriteriaLocation_' . $value['id']} ? $this->{'AuditSubCriteriaLocation_' . $value['id']}->fix_action : null;
        }
    }

    protected function getAudit($criteria_id): void
    {
        $this->isConfirm = null;
        $this->status = null;
        $this->auditSubCriteria = AuditSubCriteria::with('children.list_points', 'list_points', 'criteria.module', 'sample_methods', 'confirmance', 'non_confirmance')->findOrFail($criteria_id);
        $this->audit = Audit::with(['company', 'criteria_module.criteria.sub_criteria.children.sample_methods'])->findOrFail($this->auditSubCriteria->criteria->module->audit_id);
        $this->max = $this->auditSubCriteria->max_point;
        $this->point = $this->auditSubCriteria->point;
        $this->description = $this->auditSubCriteria->description;
        $this->fix_recommendation = $this->auditSubCriteria->confirmance?->fix_recommendation;
        $this->non_confirmance_number = $this->auditSubCriteria->non_confirmance?->non_confirmance_number;
        $this->problem_description = $this->auditSubCriteria->non_confirmance?->problem_description;
        $this->area_location_department = $this->auditSubCriteria->non_confirmance?->area_location_department;
        $this->proof = $this->auditSubCriteria->non_confirmance?->proof;
        $this->non_confirmance_description = $this->auditSubCriteria->non_confirmance?->non_confirmance_description;
        $this->category = $this->auditSubCriteria->non_confirmance?->category;

        $this->critical = $this->auditSubCriteria->is_critical;
        $this->critical_done = $this->auditSubCriteria->is_critical_done;

        $this->due_date = $this->auditSubCriteria->non_confirmance?->due_date;
        $this->audit_team_id = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->audit_team_id : $this->auditSubCriteria->confirmance?->audit_team_id;;
        $this->auditee = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditee : $this->auditSubCriteria->confirmance?->auditee;
        $this->auditee_date = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditee_date : $this->auditSubCriteria->confirmance?->auditee_date;
        $this->auditor_date = $this->auditSubCriteria->non_confirmance ? $this->auditSubCriteria->non_confirmance?->auditor_date : $this->auditSubCriteria->confirmance?->auditor_date;
        $this->root_cause_investigation = $this->auditSubCriteria->non_confirmance?->root_cause_investigation;
        $this->fix_action = $this->auditSubCriteria->non_confirmance?->fix_action;
        if ($this->auditSubCriteria->status == "confirmance") {
            $this->isConfirm = true;
        }
        if ($this->auditSubCriteria->status == "non confirmance") {
            $this->isConfirm = false;
        }

        $this->isRelation = false;
        $this->teams = $this->audit->auditors()->get();
        // dd($this->auditSubCriteria->list_points);
    }

    public function getLocationsProperty()
    {
        return AuditLocation::with('sub_sub_criteria_location')->where('audit_id', $this->audit->id)->get();
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
            if (strlen($value) > 0) {
                if (intval($value) >= $this->auditSubCriteria->target_point) {
                    $this->status = 'confirmance';
                } else {
                    $this->status = 'non confirmance';
                }
            }

            if ($this->auditSubCriteria->status) {
                if ($this->auditSubCriteria->status == $this->status) {
                    $this->isConfirm = $this->status == 'confirmance';
                }
            }
        }

        if ((stripos($name, 'category') !== FALSE) || ($name == 'critical')) {
            if ($value) {
                $this->{$name} = TRUE;
                $this->critical = TRUE;
            } else {
                $this->{$name} = FALSE;
            }
        }

        if (stripos($name, 'critical_done') !== FALSE) {
            if ($value) {
                $this->{$name} = TRUE;
            } else {
                $this->{$name} = FALSE;
            }
        }
    }

    public function confirm()
    {
        $this->validate([
            'point' => 'required|numeric|min:0|max:' . $this->max,
            'status' => 'required|in:confirmance,non confirmance'
        ]);
        try {
            \DB::beginTransaction();
            $this->auditSubCriteria->point = intval($this->point);
            $this->auditSubCriteria->status = $this->status;
            $this->auditSubCriteria->description = $this->description;
            $this->auditSubCriteria->save();
            $this->getAudit($this->auditSubCriteria->id);
            \DB::commit();

            return redirect()->route('audit::smkp.detail.criteria-audit.detail', ['id' => $this->audit->id, 'criteria_id' => $this->auditSubCriteria->id]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function PointLocation($location_id)
    {
        $ascl = AuditSubCriteriaLocation::where('audit_sub_criteria_id', $this->auditSubCriteria->id)->where('audit_location_id', $location_id)->first();

        $this->{'tooltip_' . $location_id} = $this->auditSubCriteria->list_points->where('point', $this->{'point_' . $location_id})->first()?->tooltip;
        $this->{'status_' . $location_id} = null;
        $this->{'isConfirm_' . $location_id} = null;

        if (strlen($this->{'point_' . $location_id}) > 0) {
            if (intval($this->{'point_' . $location_id}) >= $this->auditSubCriteria->target_point) {
                $this->{'status_' . $location_id} = 'confirmance';
            } else {
                $this->{'status_' . $location_id} = 'non confirmance';
            }
        }

        if ($ascl) {
            if ($ascl->status == $this->{'status_' . $location_id}) {
                $this->{'isConfirm_' . $location_id}  = $this->{'status_' . $location_id} == 'confirmance';
            }
        }
        // dd('aa');
    }

    public function IsCritical($location_id = null)
    {
        if (!$location_id) {
            \DB::beginTransaction();
            $this->auditSubCriteria->is_critical = $this->critical ? 1 : 0;
            $this->auditSubCriteria->is_critical_done = $this->critical ? 0 : 1;
            $this->auditSubCriteria->save();
            \DB::commit();
        } else {

            $ascl = AuditSubCriteriaLocation::where('audit_sub_criteria_id', $this->auditSubCriteria->id)->where('audit_location_id', $location_id)->first();

            \DB::beginTransaction();
            if ($ascl) {
                $ascl->category = $this->{'category_' . $location_id} ? 1 : 0;
                $ascl->is_critical = $this->{'category_' . $location_id} ? 1 : 0;
                $ascl->is_critical_done = $this->{'category_' . $location_id} ? 0 : 1;
                $ascl->save();
            } else {
                $this->AuditSubCriteriaLocation = new AuditSubCriteriaLocation;

                $this->AuditSubCriteriaLocation->audit_location_id = $location_id;
                $this->AuditSubCriteriaLocation->audit_sub_criteria_id = $this->auditSubCriteria->id;
                $this->AuditSubCriteriaLocation->point = intval($this->{'point_' . $location_id});
                $this->AuditSubCriteriaLocation->status = $this->{'status_' . $location_id};
                $this->AuditSubCriteriaLocation->category = $this->{'category_' . $location_id} ? 1 : 0;
                $this->AuditSubCriteriaLocation->is_critical = $this->{'category_' . $location_id} ? 1 : 0;
                $this->AuditSubCriteriaLocation->is_critical_done = $this->{'category_' . $location_id} ? 0 : 1;
                $this->AuditSubCriteriaLocation->save();
            }

            $this->auditSubCriteria->is_critical = $this->{'category_' . $location_id} ? 1 : 0;
            $this->auditSubCriteria->is_critical_done = $this->{'category_' . $location_id} ? 0 : 1;
            $this->auditSubCriteria->save();
            \DB::commit();
        }
        $this->dispatchBrowserEvent('refresh-page');
    }

    public function IsCriticalDone($location_id = null)
    {
        if (!$location_id) {
            \DB::beginTransaction();
            $this->auditSubCriteria->is_critical_done = $this->critical_done ? 1 : 0;
            $this->auditSubCriteria->save();
            \DB::commit();
        } else {
            $ascl = AuditSubCriteriaLocation::where('audit_sub_criteria_id', $this->auditSubCriteria->id)->where('audit_location_id', $location_id)->first();

            \DB::beginTransaction();
            if ($ascl) {
                $ascl->point = $this->{'point_' . $location_id};
                $ascl->is_critical_done = $this->{'is_critical_done_' . $location_id};
                $ascl->save();
            } else {

                $this->AuditSubCriteriaLocation = new AuditSubCriteriaLocation;

                $this->AuditSubCriteriaLocation->audit_location_id = $location_id;
                $this->AuditSubCriteriaLocation->audit_sub_criteria_id = $this->auditSubCriteria->id;
                $this->AuditSubCriteriaLocation->point = intval($this->{'point_' . $location_id});

                $this->AuditSubCriteriaLocation->is_critical_done = $this->{'is_critical_done_' . $location_id} ? 1 : 0;

                $this->AuditSubCriteriaLocation->save();
            }
            $this->auditSubCriteria->is_critical_done = $this->{'is_critical_done_' . $location_id} ? 1 : 0;
            $this->auditSubCriteria->save();
            \DB::commit();
        }
        $this->dispatchBrowserEvent('refresh-page');
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


        return;
    }

    public function save_location($location_id): void
    {
        if ($this->{'status_' . $location_id} == "confirmance") {
            $this->saveConfirmance($location_id);
            return;
        }

        if ($this->{'status_' . $location_id} == "non confirmance") {
            $this->saveNonConfirmance($location_id);
            return;
        }

        return;
    }

    private function saveConfirmance($location_id = null): void
    {
        if (!$location_id) {
            $this->validate([
                'audit_team_id' => 'required',
                'auditor_date' => 'nullable|date',
                'auditee' => 'nullable',
                'auditee_date' => 'nullable|date',
                'fix_recommendation' => 'nullable'
            ]);
            $confirmance = $this->auditSubCriteria->confirmance()->firstOrCreate();
            if (isset($this->fix_recommendation)) {
                $confirmance->fix_recommendation = $this->fix_recommendation;
            }

            $confirmance->audit_team_id = $this->audit_team_id;
            $confirmance->auditor_date = date('Y-m-d H:i:s', strtotime($this->auditor_date));
            $confirmance->auditee = $this->auditee;
            $confirmance->auditee_date = date('Y-m-d H:i:s', strtotime($this->auditee_date));

            $confirmance->save();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
        } else {
            // $this->validate(['audit_team_id_' . $location_id => 'required']);

            $data = [
                'audit_location_id' => $location_id,
                'audit_sub_criteria_id' => $this->auditSubCriteria->id,
                'point' => $this->{'point_' . $location_id},
                'description' => $this->{'description_' . $location_id},
                'status' => $this->{'status_' . $location_id},
                'fix_recommendation' => $this->{'fix_recommendation_' . $location_id},
            ];
            DB::beginTransaction();

            $AuditSubCriteriaLocation = AuditSubCriteriaLocation::where('audit_location_id', $location_id)
                ->where('audit_sub_criteria_id', $this->auditSubCriteria->id)
                ->first();

            if ($AuditSubCriteriaLocation) {
                $AuditSubCriteriaLocation->update($data);
            } else {
                $AuditSubCriteriaLocation = AuditSubCriteriaLocation::create($data);
            }

            DB::commit();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
        }
    }

    private function saveNonConfirmance($location_id = null): void
    {
        if (!$location_id) {
            $validate = $this->validate([
                'problem_description' => 'nullable',
                'area_location_department' => 'nullable',
                'proof' => 'nullable',
                'non_confirmance_description' => 'nullable',
                'category' => 'nullable',
                'due_date' => 'nullable|date',
                'audit_team_id' => 'required',
                'auditor_date' => 'nullable|date',
                'auditee' => 'required',
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
                'section_id' => null, //$pica->form?->ibpr->section_id ?? $pica->formIadl->iadl->section_id,
                'location_id' => null,
                'location_detail' => null,
                'company_detail' => null, //$pica->form?->ibpr->ccow->company_name ?? $pica->formIadl->iadl->ccow->company_name ,
                'pja_id' => null, //$pica->form?->ibpr->pja->id ?? $pica->formIadl->iadl->pja->id,
                'pjo_id' => null, //$pica->form?->ibpr->pjo->id ?? $pica->formIadl->iadl->pjo->id,
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
        } else {
            // $this->validate(['problem_description_' . $location_id => 'required']);

            DB::beginTransaction();

            $data = [
                'audit_location_id' => $location_id,
                'audit_sub_criteria_id' => $this->auditSubCriteria->id,
                'point' => $this->{'point_' . $location_id},
                'description' => $this->{'description_' . $location_id},
                'status' => $this->{'status_' . $location_id},
                'is_critical' => $this->{'category_' . $location_id} ? 1 : 0,
                'is_critical_done' => $this->{'is_critical_done_' . $location_id} ? 1 : 0,
                'fix_recommendation' => $this->{'fix_recommendation_' . $location_id},
                'non_confirmance_number' => $this->{'non_confirmance_number_' . $location_id},
                'problem_description' => $this->{'problem_description_' . $location_id},
                'area_location_department' => $this->{'area_location_department_' . $location_id},
                'proof' => $this->{'proof_' . $location_id},
                'non_confirmance_description' => $this->{'non_confirmance_description_' . $location_id},
                'category' => $this->{'category_' . $location_id} ? 1 : 0,
                'due_date' => Carbon::parse($this->{'due_date_' . $location_id}),
                'audit_team_id' => $this->{'audit_team_id_' . $location_id},
                'auditor_date' => Carbon::parse($this->{'auditor_date_' . $location_id}),
                'auditee' => $this->{'auditee_' . $location_id},
                'auditee_date' => Carbon::parse($this->{'auditee_date_' . $location_id}),
                'root_cause_investigation' => $this->{'root_cause_investigation_' . $location_id},
                'fix_action' => $this->{'fix_action_' . $location_id},
            ];

            $AuditSubCriteriaLocation = AuditSubCriteriaLocation::where('audit_location_id', $location_id)
                ->where('audit_sub_criteria_id', $this->auditSubCriteria->id)
                ->first();

            if ($AuditSubCriteriaLocation) {
                $AuditSubCriteriaLocation->update($data);
            } else {
                $AuditSubCriteriaLocation = AuditSubCriteriaLocation::create($data);
            }

            DB::commit();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
        }
    }

    public function render()
    {
        return view(
            'audit::livewire.criteria-audit.detail-smkp',
            [
                'module_category' => 'smkp'
            ]
        )->layout('audit::livewire.layouts.app');
    }
}
