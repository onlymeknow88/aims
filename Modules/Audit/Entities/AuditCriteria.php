<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditCriteria extends Model
{
    use HasUuids;
    protected $guarded = [];

    protected $table = 'audit_criteria';

    public function sub_criteria(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'audit_criteria_id')->where('excluded', false)->whereNull('parent_id');
    }

    public function all_sub_criteria(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'audit_criteria_id')->whereNull('parent_id');
    }

    public function elements(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'audit_criteria_id')->where('excluded', false);
    }

    public function all_elements(): HasMany
    {
        return $this->hasMany(AuditSubCriteria::class, 'audit_criteria_id');
    }

    public function module()
    {
        return $this->belongsTo(AuditCriteriaModule::class, 'audit_criteria_module_id');
    }

}
