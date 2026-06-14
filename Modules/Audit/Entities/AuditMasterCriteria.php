<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditMasterCriteria extends Model
{
    protected $guarded = [];

    protected $table = 'audit_master_criteria';

    public function sub_criteria(): HasMany
    {
        return $this->hasMany(AuditMasterSubCriteria::class)->whereNull('parent_id');
    }
}
