<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditLocation extends Model
{
    use HasUuids;
    protected $guarded = [];

    protected $fillable = [];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(Audit::class,'audit_id');
    }

    public function sub_sub_criteria_location(): HasMany
    {
        return $this->hasMany(AuditSubCriteriaLocation::class)->whereNull('audit_location_id');
    }
}
