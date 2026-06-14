<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;

class AuditMethod extends Model
{

    protected $guarded = [];

    public function sub_criteria()
    {
        return $this->belongsToMany(AuditSubCriteria::class, 'audit_sub_criteria_sample_methods');
    }

}
