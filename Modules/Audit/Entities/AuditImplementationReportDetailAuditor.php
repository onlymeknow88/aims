<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditImplementationReportDetailAuditor extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function role(): BelongsTo
    {
        return $this->belongsTo(AuditTeamRole::class,'audit_team_role_id');
    }
}
