<?php

namespace Modules\Audit\Http\Livewire\Smkp\ImplementationReport;

use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Audit\Entities\AuditImplementationReportDetailAuditor;
use Modules\Audit\Entities\AuditImplementationReportDetailComplementaryDocument;
use Modules\Audit\Entities\AuditImplementationReportDetailKeyLeadingIndicator;
use Modules\Audit\Entities\AuditImplementationReportDetailMiningEquipmentWork;
use Modules\Audit\Entities\AuditImplementationReportDetailRiskOfFuture;
use Modules\Audit\Entities\AuditImplementationReportDetailRiskOfPresent;
use Modules\Audit\Entities\AuditImplementationReportDetailStakeholder;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendActivity;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendDeviation;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendFactor;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendFactorsCausing;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendLocation;
use Modules\Audit\Entities\AuditImplementationReportDetailTrendPosition;
use Modules\Audit\Entities\AuditManDays;
use Modules\Audit\Entities\AuditRiskSeverity;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditTeam;
use Modules\Audit\Entities\AuditTeamRole;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Index extends Component
{
    public ?Audit $audit;
    public $companies = [];
    public $severities = [];
    public $progress;

    public $total_auditor = 0;

    public $total_man_power = 0;
    public $company_id;
    public $severity_id;
    public $adjustment = 0;
    public $mandays = 0;
    public $mandays_id;
    public $total_man_days = 0;
    public $firstStep = 0.0;
    public $secondStep = 0.0;

    public mixed $team_roles;
    //

    public $auditors_1;
    public $auditors_2;
    public string $name;
    public string $registration_number = "";
    public string $role_id;
    public ?string $teamId;
    public $phase;

    //
    public $head_company_id;
    public $appointment_letter_number;
    public $letter_date;
    public $audited_company_id;

    //public $responsible_id;
    //public $responsible_appointment_letter_number;
    //public $responsible_letter_date;
    public $initial_contact_date;

    public $media;
    public $auditi_delegation;
    public $auditi_delegation_position;
    public $determination_of_eligibility_date;

    public $organizational_profile;
    public $risk_profile;
    public $safety_performance_data;
    public $auditi_collaboration;
    public $time_availability;
    public $other_resources_availability;
    public $fulfillment_of_safety;
    public $eligibility_status;
    public $evaluation_of_documentation;
    public $adequacy_company_id;

    public $element_1;
    public $element_2;
    public $element_3;
    public $element_4;
    public $element_5;
    public $element_6;
    public $element_7;
    public $audited_company_id_2;
    public $proven_by;
    public $company_form_number;

    public $risk_of_present_year;
    public $risk_of_future_year;
    public $trend_location_year;
    public $trend_activity_year;
    public $trend_position_year;
    public $trend_deviation_year;
    public $trend_factors_causing_year;
    public $mining_equipment_work_year;
    public $key_leading_indicator_year;
    public $trend_factor_year;

    public $internal_audit_year;
    public $data_audit_1;
    public $data_audit_2;
    public $data_audit_3;
    public $data_audit_4;

    public $data_audit_5;
    public $previous_period_year;
    public $internal_audit_verification_year;
    public $achievement_assessment_verification_year;

    public $sampling_plan_number;
    public $audit_conformity_number;
    public $audit_non_conformity_number;
    public $non_conformity_recapitulation_number;
    public $follow_up_plan_number;
    public $recommendation_number;
    public $meeting_recording_number;
    public $initial_implementation_date;
    //

    public $complementary_documents;
    public $key_leading_indicators;
    public $mining_equipment_works;
    public $risk_of_futures;
    public $risk_of_presents;
    public $trend_activitys;
    public $trend_deviations;
    public $trend_factors_causings;
    public $trend_locations;
    public $trend_positions;

    public $trend_factors;
    public $stakeholders;
    //
    public $complementary_document;
    public $activity;
    public $risk;
    public $risk_value;
    public $location;
    public $position;
    public $deviation;
    public $causing;
    public $equipment;
    public $physical_availability;
    public $mechanical_availability;
    public $key_leading_indicator;
    public $status;
    public $factor;
    public $stakeholder_input;
    //

    protected $rules = [
        'company_id' => 'required',
        'audit.implementation_report.detail.commodity_type' => 'required',
        'audit.implementation_report.detail.permission_type' => 'required',
        'audit.implementation_report.detail.adjustment_factors.*.pivot.value' => 'required',
        'factor_0_pivot_value'=>'required',
        'factor_1_pivot_value'=>'required',
        'factor_2_pivot_value'=>'required',
        'factor_3_pivot_value'=>'required',
        'factor_4_pivot_value'=>'required',
        'factor_5_pivot_value'=>'required',
        'factor_6_pivot_value'=>'required',
        'audit.implementation_report.detail.safety_performances.*.pivot.value' => 'required',
        'audit.implementation_report.detail.eligibilities.*.pivot.value' => 'required',
    ];

    public function mount($id): void
    {
        $this->getAudit($id);
        $this->companies = Company::select(['id', 'company_name'])
            ->get();
        $this->severities = AuditRiskSeverity::select('id', 'name')
            ->get();
        $this->team_roles = AuditTeamRole::all();
    }

    protected function resetTeam(): void
    {
        $this->registration_number = "";
        $this->role_id = "";
        $this->name = "";
        $this->teamId = null;
    }

    public function phase($phase): void
    {
        $this->phase = $phase;
    }

    public function saveTeam(): void
    {
        $this->validate([
            'role_id' => 'required|exists:audit_team_roles,id',
            'name' => 'required',
            // 'registration_number' => 'required|max:191'
        ]);
        try {
            \DB::beginTransaction();
            if (isset($this->teamId)) {
                AuditImplementationReportDetailAuditor::where('id', $this->teamId)->update([
                    'name' => $this->name,
                    'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                    'audit_team_role_id' => $this->role_id,
                    'registration_number' => $this->registration_number,
                    'phase' => $this->phase
                ]);
            } else {
                AuditImplementationReportDetailAuditor::create([
                    'name' => $this->name,
                    'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                    'audit_team_role_id' => $this->role_id,
                    'registration_number' => $this->registration_number,
                    'phase' => $this->phase
                ]);
            }
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->resetTeam();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteTeam($id): void
    {
        AuditImplementationReportDetailAuditor::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->resetTeam();
        $this->saveCalculatingMandays();
    }

    protected function getAudit($id)
    {
        $this->audit = Audit::with(['implementation_report.detail' => function ($detail) {
            $detail->with(['adjustment_factors', 'safety_performances', 'eligibilities']);
        }])->withCount(['auditors'])->find($id);
        $this->company_id = $this->audit->implementation_report->detail->company_id;

        $this->total_auditor = $this->audit->auditors->where('audit_team_role_id', '!=', 3)->count();
        $this->adjustment = $this->audit->implementation_report->detail->adjustment_factors()->wherePivot('value', true)->count();
        $detail =  $this->audit->implementation_report->detail;

        $this->mandays = $detail->man_days;
        $this->severity_id = $detail->audit_risk_severity_id;
        $this->mandays_id = $detail->audit_man_days_id;
        $this->total_man_power = $detail->man_power;
        $this->total_man_days = $detail->total_man_days;
        $this->firstStep = $detail->first_step_total_man_days;
        $this->secondStep = $detail->second_step_total_man_days;

        //
        $this->auditors_1 = AuditImplementationReportDetailAuditor::where('audit_implementation_report_detail_id', $this->audit->implementation_report->detail->id)->where('phase', 1)->get();
        $this->auditors_2 = AuditImplementationReportDetailAuditor::where('audit_implementation_report_detail_id', $this->audit->implementation_report->detail->id)->where('phase', 2)->get();

        //
        $this->head_company_id = $detail->head_company_id;
        $this->appointment_letter_number = $detail->appointment_letter_number;
        $this->letter_date = $detail->letter_date;
        $this->audited_company_id = $detail->audited_company_id;
//        $this->responsible_id = $detail->responsible_id;
//        $this->responsible_appointment_letter_number = $detail->responsible_appointment_letter_number;
//        $this->responsible_letter_date = $detail->responsible_letter_date;

        $this->initial_contact_date = $detail->initial_contact_date;
        $this->media = $detail->media;
        $this->auditi_delegation = $detail->auditi_delegation;
        $this->auditi_delegation_position = $detail->auditi_delegation_position;

        $this->determination_of_eligibility_date = $detail->determination_of_eligibility_date;
        $this->organizational_profile = $detail->organizational_profile;
        $this->risk_profile = $detail->risk_profile;
        $this->safety_performance_data = $detail->safety_performance_data;
        $this->auditi_collaboration = $detail->auditi_collaboration;
        $this->time_availability = $detail->time_availability;
        $this->other_resources_availability = $detail->other_resources_availability;
        $this->fulfillment_of_safety = $detail->fulfillment_of_safety;
        $this->eligibility_status = (in_array('Tidak Laik', [$this->fulfillment_of_safety, $this->other_resources_availability, $this->time_availability, $this->auditi_collaboration, $this->safety_performance_data, $this->risk_profile, $this->organizational_profile])) ? 'Tidak Laik' : 'Laik';

        $this->adequacy_company_id = $detail->adequacy_company_id;
        $this->element_1 = $detail->element_1;
        $this->element_2 = $detail->element_2;
        $this->element_3 = $detail->element_3;
        $this->element_4 = $detail->element_4;
        $this->element_5 = $detail->element_5;
        $this->element_6 = $detail->element_6;
        $this->element_7 = $detail->element_7;
        $this->evaluation_of_documentation = (in_array('Tidak Cukup', [$this->element_1, $this->element_2, $this->element_3, $this->element_4, $this->element_5, $this->element_6, $this->element_7])) ? 'Tidak Dapat Dilanjutkan' : 'Cukup';

        $this->audited_company_id_2 = $detail->audited_company_id_2;
        $this->proven_by = $detail->proven_by;

        $this->company_form_number = $detail->company_form_number;

        $this->risk_of_present_year = $detail->risk_of_present_year;
        $this->risk_of_future_year = $detail->risk_of_future_year;
        $this->trend_location_year = $detail->trend_location_year;
        $this->trend_activity_year = $detail->trend_activity_year;
        $this->trend_position_year = $detail->trend_position_year;
        $this->trend_deviation_year = $detail->trend_deviation_year;
        $this->trend_factors_causing_year = $detail->trend_factors_causing_year;
        $this->mining_equipment_work_year = $detail->mining_equipment_work_year;
        $this->key_leading_indicator_year = $detail->key_leading_indicator_year;
        $this->internal_audit_year = $detail->internal_audit_year;

        $this->data_audit_1 = $detail->data_audit_1;
        $this->data_audit_2 = $detail->data_audit_2;
        $this->data_audit_3 = $detail->data_audit_3;
        $this->data_audit_4 = $detail->data_audit_4;
        $this->data_audit_5 = $detail->data_audit_5;

        $this->previous_period_year = $detail->previous_period_year;
        $this->internal_audit_verification_year = $detail->internal_audit_verification_year;
        $this->achievement_assessment_verification_year = $detail->achievement_assessment_verification_year;

        $this->sampling_plan_number = $detail->sampling_plan_number;
        $this->audit_conformity_number = $detail->audit_conformity_number;
        $this->audit_non_conformity_number = $detail->audit_non_conformity_number;
        $this->non_conformity_recapitulation_number = $detail->non_conformity_recapitulation_number;
        $this->follow_up_plan_number = $detail->follow_up_plan_number;
        $this->recommendation_number = $detail->recommendation_number;
        $this->meeting_recording_number = $detail->meeting_recording_number;
        $this->initial_implementation_date = $detail->initial_implementation_date;
        //
        $this->complementary_documents = AuditImplementationReportDetailComplementaryDocument::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->key_leading_indicators = AuditImplementationReportDetailKeyLeadingIndicator::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->mining_equipment_works = AuditImplementationReportDetailMiningEquipmentWork::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->risk_of_futures = AuditImplementationReportDetailRiskOfFuture::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->risk_of_presents = AuditImplementationReportDetailRiskOfPresent::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_activitys = AuditImplementationReportDetailTrendActivity::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_deviations = AuditImplementationReportDetailTrendDeviation::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_factors_causings = AuditImplementationReportDetailTrendFactorsCausing::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_locations = AuditImplementationReportDetailTrendLocation::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_positions = AuditImplementationReportDetailTrendPosition::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_factors = AuditImplementationReportDetailTrendFactor::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->stakeholders = AuditImplementationReportDetailStakeholder::where('audit_implementation_report_detail_id', $detail->id)->get();

        //

        $adjustment_factors = $detail->adjustment_factors;
        foreach ($adjustment_factors as $key => $value) {
            $key_pivot_value = "factor_".$key."_pivot_value";
            $this->$key_pivot_value = $value;
        }
        $safety_performances = $detail->safety_performances;
        $eligibilities = $detail->eligibilities;
        $ref = [
            "company_id",
            "permission_type",
            "commodity_type",
            "man_power",
            "audit_risk_severity_id"
        ];
        $progress = formProgress($ref,$detail->toArray());

        $ref_num = count($ref);
        $data_score =  ($progress * $ref_num)/100;

        $score = 0;
        foreach ($adjustment_factors as $factor) {
            if(!is_null($factor->pivot->value)){
                $score++;
            }
        }

        foreach ($safety_performances as $key => $performance) {
            if(!is_null($performance->pivot->value)){
                $score++;
            }
        }

        // foreach ($eligibilities as $eligibility) {
        //     if(!is_null($eligibility->pivot->value)){
        //         $score++;
        //     }
        // }

        $score = $score + $data_score;
        $ref_num = $ref_num + count($adjustment_factors) + count($safety_performances);// + count($eligibilities);

        if($ref_num > 0){

            $this->progress = round(($score/$ref_num)*100,2);
        }

        // print_r($eligibilities->toArray());
    }

    public function refreshSummary()
    {

        $this->evaluation_of_documentation = (in_array('Tidak Cukup', [$this->element_1, $this->element_2, $this->element_3, $this->element_4, $this->element_5, $this->element_6, $this->element_7])) ? 'Tidak Dapat Dilanjutkan' : 'Cukup';

        $this->eligibility_status = (in_array('Tidak Laik', [$this->fulfillment_of_safety, $this->other_resources_availability, $this->time_availability, $this->auditi_collaboration, $this->safety_performance_data, $this->risk_profile, $this->organizational_profile])) ? 'Tidak Laik' : 'Laik';
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    function updated($name, $value): void
    {

        if ($name == "total_man_power" || $name == "severity_id" || $name = 'audit.implementation_report.detail.safety_performances.*.pivot.value'
            || 'factor_0_pivot_value') {
            $this->internalCalculation();
        }

        if ($name == "organizational_profile" || $name == "risk_profile" || $name == "safety_performance_data" || $name == "auditi_collaboration" || $name == "time_availability" || $name == "other_resources_availability" || $name == "fulfillment_of_safety" || $name == "element_1" || $name == "element_2" || $name == "element_3" || $name == "element_4" || $name == "element_5" || $name == "element_6" || $name == "element_7") {
            $this->refreshSummary();
        }
    }

    function internalCalculation()
    {
        $this->total_man_power = (int)$this->total_man_power;
        if ($this->total_auditor <= 0) {
            return;
        }
        $risk_id = $this->severity_id;
        $manDays = AuditManDays::where('minimum_people', '<=', $this->total_man_power)
            ->where('maximum_people', '>=', $this->total_man_power)
            ->with(['severities' => function ($severity) use ($risk_id) {
                $severity->where('id', $risk_id);
            }])
            ->whereHas('severities', function ($severity) use ($risk_id) {
                $severity->where('id', $risk_id);
            })
            ->first();

        if (!$manDays) {
            return;
        }
        if ($manDays->severities->count() == 0):
            return;
        endif;
        $totalMandays = $manDays->severities[0]->pivot->value;

        $adjustmentFactor = 0;
        $this->adjustment = 0;
        foreach ($this->audit->implementation_report->detail->adjustment_factors as $key => $factor) {
            if ($factor->pivot->value) {
                $this->adjustment++;
            }
        }
        if ($this->adjustment > 0):
            $adjustmentFactor = $totalMandays / 10;
        endif;
        $finalMandays = ($totalMandays + $adjustmentFactor) / $this->total_auditor;
        $this->mandays = $totalMandays;
        $this->total_man_days = $finalMandays;
        $this->mandays_id = $manDays->id;
        $this->firstStep = round((10 / 100) * $finalMandays, 1);
        $this->secondStep = round((90 / 100) * $finalMandays, 1);
    }

//    function calculateMandays(){
//        $implementationReportDetail = $this->audit->implementation_report->detail;
//        $manPower = $implementationReportDetail->man_power;
//        $riskId = $implementationReportDetail->audit_risk_severity_id;
//        $manDays = AuditManDays::where('minimum_people', '<=', $manPower)
//            ->where('maximum_people', '>=', $manPower)
//            ->with(['severities' => function ($severity) use ($riskId) {
//                $severity->where('id', $riskId);
//            }])
//            ->whereHas('severities', function ($severity) use ($riskId) {
//                $severity->where('id', $riskId);
//            })
//            ->first();
//        if (!$manDays) {
//            return;
//        }
//        if ($manDays->severities->count() == 0):
//            return;
//        endif;
//        $totalMandays = $manDays->severities[0]->pivot->value;
//        if (!$totalMandays){
//            return;
//        }
//        $adjustmentFactor = 0;
//        $adjustment = $implementationReportDetail->adjustment_factors()->wherePivot('value', true)->count();
//        if ($adjustment > 0):
//            $adjustmentFactor = $totalMandays / 10;
//        endif;
//        $finalMandays = ($totalMandays + $adjustmentFactor) / $this->total_auditor;
//        $implementationReportDetail->man_days = $totalMandays;
//        $implementationReportDetail->total_man_days = $finalMandays;
//        $implementationReportDetail->total_adjustment_factor = $adjustment;
//        $implementationReportDetail->first_step_total_man_days = round((10 / 100) * $finalMandays, 1);
//        $implementationReportDetail->second_step_total_man_days  = round((90 / 100) * $finalMandays, 1);
//        $implementationReportDetail->save();
//    }

    public function saveInfo()
    {
        $this->validate([
            'company_id' => 'required',
            'audit.implementation_report.detail.commodity_type' => 'required',
            'audit.implementation_report.detail.permission_type' => 'required',
        ]);
        $this->audit->implementation_report->detail->update([
            'company_id' => $this->company_id,
            'commodity_type' => $this->audit->implementation_report->detail->commodity_type,
            'permission_type' => $this->audit->implementation_report->detail->permission_type,
        ]);
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
        $this->getAudit($this->audit->id);
    }

    public function saveSafetyPerformance()
    {
        $this->validate([
            'audit.implementation_report.detail.safety_performances.*.pivot.value' => 'required',
        ]);
        foreach ($this->audit->implementation_report->detail->safety_performances as $safety_performance):
            $this->audit->implementation_report->detail->safety_performances()->updateExistingPivot($safety_performance->id, [
                'value' => $safety_performance->pivot->value
            ]);
        endforeach;
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
        $this->getAudit($this->audit->id);
    }

    public function saveAdjustmentFactor()
    {
        $this->validate([
            'audit.implementation_report.detail.adjustment_factors.*.pivot.value' => 'required|in:0,1',
        ]);
        foreach ($this->audit->implementation_report->detail->adjustment_factors as $adjustment_factor):
            $this->audit->implementation_report->detail->adjustment_factors()->updateExistingPivot($adjustment_factor->id, [
                'value' => $adjustment_factor->pivot->value
            ]);
        endforeach;
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
        $this->adjustment = $this->audit->implementation_report->detail->adjustment_factors()->wherePivot('value', true)->count();
        $this->audit->implementation_report->detail->update(['total_adjustment_factor' => $this->adjustment]);
        $this->getAudit($this->audit->id);
    }

    public function saveCalculatingMandays()
    {
        $this->validate([
            'company_id' => 'required',
            'audit.implementation_report.detail.commodity_type' => 'required',
            'audit.implementation_report.detail.permission_type' => 'required',
            'audit.implementation_report.detail.adjustment_factors.*.pivot.value' => 'required|in:0,1',
            'audit.implementation_report.detail.safety_performances.*.pivot.value' => 'required',
            'total_man_power' => 'required|numeric|min:1',
            'total_auditor' => 'required|numeric|min:1',
            'severity_id' => 'required|exists:audit_risk_severities,id',
            'mandays_id' => 'required|exists:audit_man_days,id',
        ]);
        try {
            \DB::beginTransaction();
            $this->audit->implementation_report->detail->update([
                'company_id' => $this->company_id,
                'commodity_type' => $this->audit->implementation_report->detail->commodity_type,
                'permission_type' => $this->audit->implementation_report->detail->permission_type,
                'total_adjustment_factor' => $this->adjustment,
                'man_power' => $this->total_man_power,
                'audit_man_days_id' => $this->mandays_id,
                'man_days' => $this->mandays,
                'total_man_days' => $this->total_man_days,
                'audit_risk_severity_id' => $this->severity_id,
                'first_step_total_man_days' => $this->firstStep,
                'second_step_total_man_days' => $this->secondStep,

                //
                'head_company_id' => $this->head_company_id,
                'appointment_letter_number' => $this->appointment_letter_number,
                'letter_date' => Carbon::parse($this->letter_date)->format('Y-m-d'),
                'audited_company_id' => $this->audited_company_id,

//                'responsible_id' => $this->responsible_id,
//                'responsible_appointment_letter_number' => $this->responsible_appointment_letter_number,
//                'responsible_letter_date' => Carbon::parse($this->responsible_letter_date)->format('Y-m-d'),

                'initial_contact_date' => Carbon::parse($this->initial_contact_date)->format('Y-m-d'),
                'media' => $this->media,
                'auditi_delegation' => $this->auditi_delegation,
                'auditi_delegation_position' => $this->auditi_delegation_position,

                'determination_of_eligibility_date' => Carbon::parse($this->determination_of_eligibility_date)->format('Y-m-d'),
                'organizational_profile' => $this->organizational_profile,
                'risk_profile' => $this->risk_profile,
                'safety_performance_data' => $this->safety_performance_data,
                'auditi_collaboration' => $this->auditi_collaboration,
                'time_availability' => $this->time_availability,
                'other_resources_availability' => $this->other_resources_availability,
                'fulfillment_of_safety' => $this->fulfillment_of_safety,

                'adequacy_company_id' => $this->adequacy_company_id,
                'element_1' => $this->element_1,
                'element_2' => $this->element_2,
                'element_3' => $this->element_3,
                'element_4' => $this->element_4,
                'element_5' => $this->element_5,
                'element_6' => $this->element_6,
                'element_7' => $this->element_7,

                'audited_company_id_2' => $this->audited_company_id_2,
                'proven_by' => $this->proven_by,

                'company_form_number' => $this->company_form_number,
                'risk_of_present_year' => $this->risk_of_present_year,
                'risk_of_future_year' => $this->risk_of_future_year,
                'trend_location_year' => $this->trend_location_year,
                'trend_activity_year' => $this->trend_activity_year,
                'trend_position_year' => $this->trend_position_year,
                'trend_deviation_year' => $this->trend_deviation_year,
                'trend_factor_year' => $this->trend_factor_year,
                'trend_factors_causing_year' => $this->trend_factors_causing_year,
                'mining_equipment_work_year' => $this->mining_equipment_work_year,
                'key_leading_indicator_year' => $this->key_leading_indicator_year,
                'internal_audit_year' => $this->internal_audit_year,

                'data_audit_1' => $this->data_audit_1,
                'data_audit_2' => $this->data_audit_2,
                'data_audit_3' => $this->data_audit_3,
                'data_audit_4' => $this->data_audit_4,
                'data_audit_5' => $this->data_audit_5,

                'previous_period_year' => $this->previous_period_year,
                'internal_audit_verification_year' => $this->internal_audit_verification_year,
                'achievement_assessment_verification_year' => $this->achievement_assessment_verification_year,

                'sampling_plan_number' => $this->sampling_plan_number,
                'audit_conformity_number' => $this->audit_conformity_number,
                'audit_non_conformity_number' => $this->audit_non_conformity_number,
                'non_conformity_recapitulation_number' => $this->non_conformity_recapitulation_number,
                'follow_up_plan_number' => $this->follow_up_plan_number,
                'recommendation_number' => $this->recommendation_number,
                'meeting_recording_number' => $this->meeting_recording_number,
                'initial_implementation_date' => Carbon::parse($this->initial_implementation_date)->format('Y-m-d'),
            ]);
            foreach ($this->audit->implementation_report->detail->safety_performances as $safety_performance):
                $this->audit->implementation_report->detail->safety_performances()->updateExistingPivot($safety_performance->id, [
                    'value' => $safety_performance->pivot->value
                ]);
            endforeach;
            foreach ($this->audit->implementation_report->detail->adjustment_factors as $adjustment_factor):
                $this->audit->implementation_report->detail->adjustment_factors()->updateExistingPivot($adjustment_factor->id, [
                    'value' => $adjustment_factor->pivot->value
                ]);
            endforeach;
            $this->adjustment = $this->audit->implementation_report->detail->adjustment_factors()->wherePivot('value', true)->count();
            $this->audit->implementation_report->detail->update(['total_adjustment_factor' => $this->adjustment]);
            \DB::commit();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            $this->getAudit($this->audit->id);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
        }
    }

    public function generateWord($id)
    {
        $this->audit = Audit::with(['implementation_report.detail' => function ($detail) {
            $detail->with(['adjustment_factors', 'safety_performances', 'eligibilities']);
        }])->withCount(['auditors'])->find($id);
        $this->company_id = $this->audit->implementation_report->detail->company_id;

        $detail =  $this->audit->implementation_report->detail;
        $this->total_auditor = $this->audit->auditors->where('audit_team_role_id', '!=', 3)->count();
        $this->adjustment = $this->audit->implementation_report->detail->adjustment_factors()->wherePivot('value', true)->count();

        //
        $this->auditors_1 = AuditImplementationReportDetailAuditor::where('audit_implementation_report_detail_id', $this->audit->implementation_report->detail->id)->where('phase', 1)->get();
        $this->auditors_2 = AuditImplementationReportDetailAuditor::where('audit_implementation_report_detail_id', $this->audit->implementation_report->detail->id)->where('phase', 2)->get();

        $this->complementary_documents = AuditImplementationReportDetailComplementaryDocument::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->key_leading_indicators = AuditImplementationReportDetailKeyLeadingIndicator::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->mining_equipment_works = AuditImplementationReportDetailMiningEquipmentWork::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->risk_of_futures = AuditImplementationReportDetailRiskOfFuture::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->risk_of_presents = AuditImplementationReportDetailRiskOfPresent::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_activitys = AuditImplementationReportDetailTrendActivity::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_deviations = AuditImplementationReportDetailTrendDeviation::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_factors_causings = AuditImplementationReportDetailTrendFactorsCausing::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_locations = AuditImplementationReportDetailTrendLocation::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_positions = AuditImplementationReportDetailTrendPosition::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->trend_factors = AuditImplementationReportDetailTrendFactor::where('audit_implementation_report_detail_id', $detail->id)->get();
        $this->stakeholders = AuditImplementationReportDetailStakeholder::where('audit_implementation_report_detail_id', $detail->id)->get();

        $viewContent = view('audit::livewire.smkp.implementation-report.export-word', [
            'audit_category' => 'SMKP',
            'audit' => $this->audit,
            'detail' => $detail,
            'total_auditor' => $this->total_auditor,
            'adjustment' => $this->adjustment,

            'complementary_documents' => $this->complementary_documents,
            'auditors_1' => $this->auditors_1,
            'auditors_2' => $this->auditors_2,
            'key_leading_indicators' => $this->key_leading_indicators,
            'mining_equipment_works' => $this->mining_equipment_works,
            'risk_of_futures' => $this->risk_of_futures,
            'risk_of_presents' => $this->risk_of_presents,
            'trend_activitys' => $this->trend_activitys,
            'trend_deviations' => $this->trend_deviations,
            'trend_factors_causings' => $this->trend_factors_causings,
            'trend_locations' => $this->trend_locations,
            'trend_positions' => $this->trend_positions,
            'trend_factors' => $this->trend_factors,
            'stakeholders' => $this->stakeholders,
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-implementation-schedule.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-implementation-schedule.docx'))->deleteFileAfterSend(true);
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Implementation Report')) {
            return view('audit::livewire.smkp.implementation-report.index')->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
    }

    protected function resetInput(): void
    {
        $this->complementary_document = "";
        $this->activity = "";
        $this->risk = "";
        $this->risk_value = "";
        $this->location = "";
        $this->position = "";
        $this->deviation = "";
        $this->causing = "";
        $this->equipment = "";
        $this->physical_availability = "";
        $this->mechanical_availability = "";
        $this->key_leading_indicator = "";
        $this->status = "";
        $this->factor = "";
        $this->stakeholder_input = "";
    }

    public function saveComplementaryDocument(): void
    {
        $this->validate([
            'complementary_document' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailComplementaryDocument::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'document' => $this->complementary_document,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteComplementaryDocument($id): void
    {
        AuditImplementationReportDetailComplementaryDocument::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveRiskOfPresents(): void
    {
        $this->validate([
            'activity' => 'required',
            'risk' => 'required',
            'risk_value' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailRiskOfPresent::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'activity' => $this->activity,
                'risk' => $this->risk,
                'risk_value' => $this->risk_value,
            ]);
            \DB::commit();

            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteRiskOfPresents($id): void
    {
        AuditImplementationReportDetailRiskOfPresent::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveRiskOfFuture(): void
    {
        $this->validate([
            'activity' => 'required',
            'risk' => 'required',
            'risk_value' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailRiskOfFuture::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'activity' => $this->activity,
                'risk' => $this->risk,
                'risk_value' => $this->risk_value,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteRiskOfFuture($id): void
    {
        AuditImplementationReportDetailRiskOfFuture::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveLocation(): void
    {
        $this->validate([
            'location' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendLocation::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'location' => $this->location,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteLocation($id): void
    {
        AuditImplementationReportDetailTrendLocation::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveActivity(): void
    {
        $this->validate([
            'activity' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendActivity::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'activity' => $this->activity,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteActivity($id): void
    {
        AuditImplementationReportDetailTrendActivity::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function savePosition(): void
    {
        $this->validate([
            'position' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendPosition::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'position' => $this->position,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deletePosition($id): void
    {
        AuditImplementationReportDetailTrendPosition::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveDeviation(): void
    {
        $this->validate([
            'deviation' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendDeviation::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'deviation' => $this->deviation,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteDeviation($id): void
    {
        AuditImplementationReportDetailTrendDeviation::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveCausing(): void
    {
        $this->validate([
            'causing' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendFactorsCausing::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'causing' => $this->causing,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteCausing($id): void
    {
        AuditImplementationReportDetailTrendFactorsCausing::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveMiningEquipmentWork(): void
    {
        $this->validate([
            'equipment' => 'required',
            'physical_availability' => 'required',
            'mechanical_availability' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailMiningEquipmentWork::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'equipment' => $this->equipment,
                'physical_availability' => $this->physical_availability,
                'mechanical_availability' => $this->mechanical_availability,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteMiningEquipmentWork($id): void
    {
        AuditImplementationReportDetailMiningEquipmentWork::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveKeyLeadingIndicator(): void
    {
        $this->validate([
            'key_leading_indicator' => 'required',
            'status' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailKeyLeadingIndicator::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'key_leading_indicator' => $this->key_leading_indicator,
                'status' => $this->status,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteKeyLeadingIndicator($id): void
    {
        AuditImplementationReportDetailKeyLeadingIndicator::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveFactor(): void
    {
        $this->validate([
            'factor' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailTrendFactor::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'factor' => $this->factor,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteFactor($id): void
    {
        AuditImplementationReportDetailTrendFactor::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }

    public function saveStakeholder(): void
    {
        $this->validate([
            'stakeholder_input' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            AuditImplementationReportDetailStakeholder::create([
                'audit_implementation_report_detail_id' => $this->audit->implementation_report->detail->id,
                'stakeholder_input' => $this->stakeholder_input,
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetInput();
            $this->saveCalculatingMandays();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteStakeholder($id): void
    {
        AuditImplementationReportDetailStakeholder::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInput();
        $this->saveCalculatingMandays();
    }
}
