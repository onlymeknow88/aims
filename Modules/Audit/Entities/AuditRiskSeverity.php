<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;

class AuditRiskSeverity extends Model
{
    protected $guarded = [];

    public function man_days(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AuditManDays::class,'audit_man_days_risk_severity')->withPivot(['value']);
    }
}
