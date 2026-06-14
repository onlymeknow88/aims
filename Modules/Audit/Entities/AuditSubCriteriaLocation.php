<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditSubCriteriaLocation extends Model
{
    use HasUuids;
    protected $guarded = [];


    protected $fillable = [
        'audit_location_id',
        'audit_sub_criteria_id',
        'point',
        'description',
        'status',
        'is_critical',
        'is_critical_done',
        'fix_recommendation',
        'non_confirmance_number',
        'problem_description',
        'area_location_department',
        'proof',
        'non_confirmance_description',
        'category',
        'due_date',
        'audit_team_id',
        'auditor_date',
        'auditee',
        'auditee_date',
        'root_cause_investigation',
        'fix_action',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(AuditLocation::class, 'audit_location_id');
    }
}
