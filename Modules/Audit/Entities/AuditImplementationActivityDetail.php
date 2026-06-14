<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditImplementationActivityDetail extends Model
{
    use HasUuids;

    protected $guarded = [];
    protected $casts = [
        'date' => 'date'
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(AuditImplementationActivityDetailSchedule::class, 'audit_implementation_activity_detail_id')->orderBy('start_time');
    }

    public function activity()
    {
        return $this->belongsTo(AuditImplementationActivity::class, 'audit_implementation_activity_id');
    }
}
