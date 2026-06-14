<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AuditPlan extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function detail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AuditPlanDetail::class, 'audit_plan_id')->orderBy('id', 'desc');
    }
}
