<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditMasterSubCriteria extends Model
{
    protected $guarded = [];
    protected $table = 'audit_master_sub_criteria';

    public function children(): HasMany
    {
        return $this->hasMany(AuditMasterSubCriteria::class,'parent_id');
    }

    public function list_points(): HasMany
    {
        return $this->hasMany(AuditMasterSubCriteriaPoint::class);
    }

}
