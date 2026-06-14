<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditCriteriaConfirmance extends Model
{
    use HasUuids;

    protected $guarded = [];


    public function audit_sub_criteria(): BelongsTo
    {
        return $this->BelongsTo(AuditSubCriteria::class,'audit_sub_criteria_id');
    }

    public function audit_team(): BelongsTo
    {
        return $this->BelongsTo(AuditTeam::class,'audit_team_id');
    }


}
