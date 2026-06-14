<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AuditImplementationActivityDetailSchedule extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function auditors(): BelongsToMany
    {
        return $this->belongsToMany(AuditTeam::class, 'audit_implementation_activity_schedule_team');
    }

    public function sub_criteria(): BelongsToMany
    {
        return $this->belongsToMany(AuditSubCriteria::class, 'audit_implementation_activity_schedule_sub_criteria');
    }

    public function detail()
    {
        return $this->belongsTo(AuditImplementationActivityDetail::class, 'audit_implementation_activity_detail_id');
    }

}
