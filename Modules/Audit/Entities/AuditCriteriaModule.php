<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditCriteriaModule extends Model
{
    use HasUuids;
    protected $guarded=[];

    public function criteria(): HasMany
    {
        return $this->hasMany(AuditCriteria::class,'audit_criteria_module_id')->where('excluded', false);
    }

    public function audit(): BelongsTo
    {
        return $this->BelongsTo(Audit::class,'audit_id');
    }

}
