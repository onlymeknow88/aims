<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;

class AuditManDaysRiskSeverity extends Model
{   
    protected $table = 'audit_man_days_risk_severity';
    protected $guarded = [];
    public $timestamps = false;
}
