<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditImplementationActivity extends Model
{
    use HasUuids;

    protected $guarded = [];


    public function details(): HasMany
    {
        return $this->hasMany(AuditImplementationActivityDetail::class, 'audit_implementation_activity_id')->orderBy('date', 'asc');
    }
}
