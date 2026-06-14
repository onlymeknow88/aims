<?php

namespace Modules\Audit\Http\Livewire\Iso9001\Dashboard;

use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\BundleStatusEnum;
use Carbon\Carbon;


class Index extends Component
{
    public $audits = [];
    private $years = [];
    private $companies_ccow;
    private $companies;
    private $percentages;
    private $statuses;
    private $audit_category = \Modules\Audit\Enums\AuditCategory::ISO9001;

    public function mount()
    {
        $this->getAudits();
    }


    public function getAudits(){

        $audits = Audit::with(['company','criteria_module.criteria.sub_criteria.children'])
            ->where("audit_category",$this->audit_category)
            ->whereYear('end_at',date('Y'))
            ->get();
        
        // dd($audits);

        $statuses = [];
        foreach (BundleStatusEnum::asArray() as $key => $value) {
            $statuses[$value] = 0;
        }

        foreach ($audits as $key => $audit) {
            $target_point = 0;
            $total_point = 0;
            $criteria = $audit->criteria_module->criteria;
            
            foreach ($criteria as $criterionKey => $criterion) {
                $subCriteria = $criterion->sub_criteria;
                foreach ($subCriteria as $subKey => $subCriterion) {
                    if($subCriterion->has_point == 1){
                        $target_point += $subCriterion->target_point;
                        $total_point += $subCriterion->point;
                    }

                    if($subCriterion->children){
                        $childs = $subCriterion->children;
                        foreach ($childs as $childKey => $child) {
                            if($child->has_point == 1){
                                $target_point += $child->target_point;
                                $total_point += $child->point;
                            }
                            
                        }
                    }
                }
            }
            
            $audits[$key]->percent = $target_point > 0 ? round((($total_point/$target_point)*100),2) : 0;

            foreach (BundleStatusEnum::asArray() as $key => $value) {
                if($value == $audit->status){
                    $statuses[$value]++;
                }
            }
            
            
        }

        $this->statuses = [
            'labels' => array_keys($statuses),
            'data' => array_values($statuses)
        ];

        // dd($statuses);

        $data_percentage = [];
        $label_percentage = [];

        foreach ($audits as $key => $value) {
            $data_percentage[] =$value->percent;
            $label_percentage[] = $value->company->company_name;
        }

        $this->percentages = [
            'labels' => $label_percentage,
            'data' => $data_percentage
        ];
        // dd($this->percentages);

        $companies_ccow = Audit::with('company')
        ->whereHas('company', function ($query) {
            return $query->where('type', '=', 'INTERNAL');
        })
        ->where(
            [
                'audit_category'=>$this->audit_category,

            ]
        )
        ->whereYear('end_at',date('Y'))
        ->groupBy('company_id')
        ->selectRaw('count(*) as total, company_id')
        ->get();

        $data_companies_ccow = [];
        $label_companies_ccow = [];

        foreach ($companies_ccow as $key => $value) {
            $data_companies_ccow[] =$value->total;
            $label_companies_ccow[] = $value->company->company_name;
        }

        $this->companies_ccow = [
            'labels' => $label_companies_ccow,
            'data' => $data_companies_ccow
        ];

        $companies = Audit::with('company')
        ->whereHas('company', function ($query) {
            return $query->where('type', '!=', 'INTERNAL');
        })
        
        ->where(
            [
                'audit_category'=>$this->audit_category,

            ]
        )
        ->whereYear('end_at',date('Y'))
        ->groupBy('company_id')
        ->selectRaw('count(*) as total, company_id')
        ->get();

        $data_companies = [];
        $label_companies = [];

        foreach ($companies as $key => $value) {
            $data_companies[] =$value->total;
            $label_companies[] = $value->company->company_name;
        }

        $this->companies = [
            'labels' => $label_companies,
            'data' => $data_companies
        ];
        
        $years = Audit::where([
            'audit_category'=>$this->audit_category
        ])->orderBy('end_at')
            ->get()
            ->groupBy(function($val) {
            return Carbon::parse($val->end_at)->format('Y');
        });

        

        $range_years = range(date('Y')-4,date('Y'));

        foreach ($range_years as $key => $value) {
            if(isset($years[$value]))
                $data_years[] = count($years[$value]);
            else
            $data_years[] = 0;
        }
        
    
        $this->years = [
            'labels' => $range_years,
            'data' => $data_years
        ];
    }

    public function render()
    {
        return view('audit::livewire.dashboard.index',[
            'audit_category'=>strtolower($this->audit_category),
            'years'=>$this->years,
            'companies_ccow'=>$this->companies_ccow,
            'companies'=>$this->companies,
            'percentages'=>$this->percentages,
            'statuses' => $this->statuses
        ])->layout('audit::livewire.layouts.app');
    }
}
