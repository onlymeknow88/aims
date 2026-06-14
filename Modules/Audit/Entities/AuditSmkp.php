<?php

namespace Modules\Audit\Entities;

use App\Models\Company;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuditSmkp extends Model
{
   use HasUuids;
    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $company = Company::find($model->company_id);
            $len = strlen("SMKP-".$company->document_code."-".date("Y")."-");
            $config = [
                'table' => 'audit_smkps',
                'field'=>'audit_number',
                'length' => $len+3,
                'prefix'=>"SMKP-".$company->document_code."-".date("Y")."-",
                "reset_on_prefix_change"=>true
            ];
            $model->audit_number = IdGenerator::generate($config);
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function auditors(): HasMany
    {
        return $this->hasMany(AuditSmkpTeam::class,'audit_smkp_id');
    }

    public function evaluators(): HasMany
    {
        return $this->hasMany(AuditEvaluator::class, 'audit_smkp_id');
    }

    public function notice_letters(): HasMany
    {
        return $this->hasMany(AuditSmkpNoticeLetter::class,'audit_smkp_id');
    }

    public function opening_attendances(): HasMany
    {
        return $this->hasMany(AuditOpeningAttendance::class,'audit_smkp_id');
    }

    public function closing_attendances(): HasMany
    {
        return $this->hasMany(AuditClosingAttendance::class,'audit_smkp_id');
    }

    public function response_audits(): HasMany
    {
        return $this->hasMany(AuditResponseAudit::class,'audit_smkp_id');
    }

    public function report_results(): HasMany
    {
        return $this->hasMany(AuditReportResult::class,'audit_smkp_id');
    }

    public function another_attachments(): HasMany
    {
        return $this->hasMany(AuditAnotherAttachment::class,'audit_smkp_id');
    }


    public function audit_plan(): HasOne
    {
        return $this->hasOne(AuditPlan::class,'audit_smkp_id');
    }

    public function implementation_activity(): HasOne
    {
        return $this->hasOne(AuditImplementationActivity::class,'audit_smkp_id');
    }

    public function criteria_module(): HasOne
    {
        return $this->hasOne(AuditCriteriaModule::class,'audit_smkp_id');
    }

    public function implementation_report(): HasOne
    {
        return $this->hasOne(AuditImplementationReportModule::class,'audit_smkp_id');
    }
}
