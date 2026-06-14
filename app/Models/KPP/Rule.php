<?php

namespace App\Models\KPP;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperRule
 */
class Rule extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function agencyAuthority(): BelongsTo
    {
        return $this->belongsTo(AgencyAuthority::class)->withTrashed();
    }

    public function ruleType(): BelongsTo
    {
        return $this->belongsTo(RuleType::class, 'rule_type_id')->withTrashed();
    }

    public function ruleStatus(): BelongsTo
    {
        return $this->belongsTo(RuleStatus::class, 'rule_status_id')->withTrashed();
    }
}
