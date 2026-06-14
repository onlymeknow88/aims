<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AuditManDays extends Model
{
    protected $guarded =[];

    public function severities(): BelongsToMany
    {
        return $this->belongsToMany(AuditRiskSeverity::class,'audit_man_days_risk_severity')->withPivot(['value']);
    }
}
