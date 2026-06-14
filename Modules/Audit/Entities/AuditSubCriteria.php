<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuditSubCriteria extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $table = 'audit_sub_criteria';

    public function children(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'parent_id')->where('excluded', false);
    }

    public function all_children(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'parent_id');
    }

    public function list_points(): HasMany
    {
        return $this->hasMany(AuditSubCriteriaPoint::class, 'audit_sub_criteria_id');
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(AuditCriteria::class, 'audit_criteria_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AuditSubCriteria::class, 'parent_id');
    }

    public function sample_methods(): BelongsToMany
    {
        return $this->belongsToMany(AuditMethod::class, 'audit_sub_criteria_sample_methods')->withPivot('sample');
    }

    public function confirmance(): HasOne
    {
        return $this->hasOne(AuditCriteriaConfirmance::class);
    }

    public function non_confirmance(): HasOne
    {
        return $this->hasOne(AuditCriteriaNonConfirmance::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(AuditSubCriteriaLocation::class, 'audit_sub_criteria_id');
    }
}
