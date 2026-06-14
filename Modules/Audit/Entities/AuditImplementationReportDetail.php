<?php

namespace Modules\Audit\Entities;

use App\Models\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditImplementationReportDetail extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function safety_performances(): BelongsToMany
    {
        return $this->belongsToMany(AuditMasterSafetyPerformance::class,'audit_report_module_safety_performance')
            ->withPivot(['value']);
    }
    public function eligibilities(): BelongsToMany
    {
        return $this->belongsToMany(AuditMasterEligibility::class,'audit_report_module_eligibility')
            ->withPivot(['value']);
    }

    public function adjustment_factors(): BelongsToMany
    {
        return $this->belongsToMany(AuditMasterAdjustmentFactor::class,'audit_report_module_adjustment_factor')
            ->withPivot(['value']);
    }

    public function calculateManDays(): void
    {
        if ((int)$this->man_power == 0 || (int)$this->total_auditor == 0 || $this->audit_risk_severity_id == null){
            return;
        }else{
            $riskId = $this->audit_risk_severity_id;
            $manDays = AuditManDays::where('minimum_people', '<=', $this->man_power)
                ->where('maximum_people', '>=', $this->man_power)
                ->with(['severities' => function ($severity) use ($riskId) {
                    $severity->where('id', $riskId);
                }])
                ->whereHas('severities', function ($severity) use ($riskId) {
                    $severity->where('id', $riskId);
                })
                ->first();
            if (!$manDays){
                return;
            }
            if ($manDays->severities->count() == 0):
                return;
            endif;
            $totalMandays = $manDays->severities[0]->pivot->value;
            $adjustmentFactor = 0;
            if ($this->total_adjustment_factor > 0):
                $adjustmentFactor = $totalMandays / 10;
            endif;
            $finalMandays = ($totalMandays + $adjustmentFactor) / $this->total_auditor;
            $this->audit_man_days_id = $manDays->id;
            $this->total_man_days = $finalMandays;
            $this->first_step_total_man_days = round((10/100) * $finalMandays,1);
            $this->second_step_total_man_days = round((90/100) * $finalMandays,1);
            $this->save();
        }
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function auditors(): HasMany
    {
        return $this->hasMany(AuditImplementationReportDetailAuditor::class,'audit_implementation_report_detail_id');
    }

    public function headCcompany(): BelongsTo
    {
        return $this->belongsTo(Company::class,'head_company_id');
    }

    public function auditedCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class,'audited_company_id');
    }

    public function adequacyCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class,'adequacy_company_id');
    }

    public function audited2Company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'audited_company_id_2');
    }

    public function head2Ccompany(): BelongsTo
    {
        return $this->belongsTo(Company::class,'head_2_company_id');
    }
}
