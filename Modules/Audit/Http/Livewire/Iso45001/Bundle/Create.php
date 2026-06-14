<?php

namespace Modules\Audit\Http\Livewire\Iso45001\Bundle;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Modules\Audit\Entities\AuditMasterAdjustmentFactor;
use Modules\Audit\Entities\AuditMasterCriteria;
use Modules\Audit\Entities\AuditMasterEligibility;
use Modules\Audit\Entities\AuditMasterSafetyPerformance;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\AuditType;
use Modules\Audit\Enums\AuditCategory;
use Modules\Audit\Enums\BundleStatusEnum;


class Create extends Component
{
    public $companies = [];

    public string $title = "";
    public string $company_id = "";
    public string $audit_type = "";
    public string $audit_number = "";
    public string $start_date = "";
    public string $end_date = "";
    public string $audit_time = "";
    public string $audit_category = AuditCategory::ISO45001;

    protected $rules = [
        'company_id' => 'required|exists:companies,id',
        'title' => 'required|max:191',
        'audit_type' => 'required|enum_value:' . AuditType::class,
        'start_date'=>'required|date',
        'end_date'=>'required|date|after:start_at',
    ];

    public function mount(): void
    {


        $this->companies = Company::select('id', 'company_name')
            ->get();
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    public function store(): bool | \Illuminate\Http\RedirectResponse |Redirector
    {
        $this->validate();
        try {
            \DB::beginTransaction();
            $audit = Audit::create([
                'status' => BundleStatusEnum::DRAFT,
                'title' => $this->title,
                'company_id' => $this->company_id,
                'audit_type' => $this->audit_type,
                'start_at' => Carbon::parse($this->start_date)->format('Y-m-d'),
                'end_at' => Carbon::parse($this->end_date)->format('Y-m-d'),
                'audit_category' => $this->audit_category,
            ]);
            $plan = $audit->audit_plan()->create();
            $plan->detail()->create();
            $audit->implementation_activity()->create();
            $moduleCriteria = $audit->criteria_module()->create();
            $masterCriteria = AuditMasterCriteria::with(['sub_criteria' => function ($sub) {

                // $sub->with('children.list_points', 'list_points');
                $sub->with(['children' => function($subChildren){
                    $subChildren->with(['children' => function($subChildChildren){
                        $subChildChildren->with('children.list_points');
                    }],'list_points');
                }],'list_points'); //list_points


            }])->where("audit_category",$this->audit_category)->get();


            foreach ($masterCriteria as $masterCriterion):

                $criteria = $moduleCriteria->criteria()->create([
                    'title' => $masterCriterion->title,
                    'subtitle' => $masterCriterion->subtitle,
                    'audit_master_criteria_id' => $masterCriterion->id
                ]);

                foreach ($masterCriterion->sub_criteria as $sub_criterion):

                    $subCriteria = $criteria->sub_criteria()->create([
                        'title' => $sub_criterion->title,
                        'has_point' => $sub_criterion->has_point,
                        'max_point' => $sub_criterion->max_point,
                        'target_point' => $sub_criterion->target_point,
                        'audit_master_sub_criteria_id' => $sub_criterion->id,
                    ]);
                    foreach ($sub_criterion->list_points as $list_point):
                        $subCriteria->list_points()->create([
                            'point' => $list_point->point,
                            'tooltip' => $list_point->tooltip,
                            'audit_master_sub_criteria_point_id' =>$list_point->id
                        ]);
                    endforeach;
                    foreach ($sub_criterion->children as $child):

                        $atttr = $subCriteria->children()->create([
                            'audit_criteria_id' => $criteria->id,
                            'title' => $child->title,
                            'has_point' => $child->has_point,
                            'max_point' => $child->max_point,
                            'target_point' => $child->target_point,
                            'audit_master_sub_criteria_id' => $child->id
                        ]);
                        foreach ($child->list_points as $point):
                            $atttr->list_points()->create([
                                'point' => $point->point,
                                'tooltip' => $point->tooltip,
                                'audit_master_sub_criteria_point_id' => $point->id
                            ]);
                        endforeach;

                        foreach ($child->children as $subChildren) {
                            $attrSub = $atttr->children()->create([
                                'audit_criteria_id' => $criteria->id,
                                'title' => $subChildren->title,
                                'has_point' => $subChildren->has_point,
                                'max_point' => $subChildren->max_point,
                                'target_point' => $subChildren->target_point,
                                'audit_master_sub_criteria_id' => $subChildren->id
                            ]);

                            foreach ($subChildren->list_points as $point):
                                $attrSub->list_points()->create([
                                    'point' => $point->point,
                                    'tooltip' => $point->tooltip,
                                    'audit_master_sub_criteria_point_id' => $point->id
                                ]);
                            endforeach;

                            foreach ($subChildren->children as $subChildChildren) {

                                $attrSubChild = $attrSub->children()->create([
                                    'audit_criteria_id' => $criteria->id,
                                    'title' => $subChildChildren->title,
                                    'has_point' => $subChildChildren->has_point,
                                    'max_point' => $subChildChildren->max_point,
                                    'target_point' => $subChildChildren->target_point,
                                    'audit_master_sub_criteria_id' => $subChildChildren->id
                                ]);

                                foreach ($subChildChildren->list_points as $point):
                                    $attrSubChild->list_points()->create([
                                        'point' => $point->point,
                                        'tooltip' => $point->tooltip,
                                        'audit_master_sub_criteria_point_id' => $point->id
                                    ]);
                                endforeach;
                            }
                        }
                    endforeach;
                endforeach;
            endforeach;

            $implementationReport = $audit->implementation_report()->create();
            $implementationReportDetail = $implementationReport->detail()->create();
            $implementationReportDetail->eligibilities()->sync(AuditMasterEligibility::where('is_active', true)->get());
            $implementationReportDetail->safety_performances()->sync(AuditMasterSafetyPerformance::where('is_active', true)->get());
            $implementationReportDetail->adjustment_factors()->sync(AuditMasterAdjustmentFactor::where('is_active', true)->get());
            \DB::commit();
            \Session::flash('success', 'Berhasil menginputkan data');
            return redirect()->route('audit::iso45001.detail.index', ['id' => $audit->id]);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }


    public function render(): Factory|View|Application
    {
        if (\Auth::user()->hasPermissionTo('Audit - Create SMKP')) {
            return view('audit::livewire.bundle.create',[
                'category'=>'iso45001'
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

    }
}
