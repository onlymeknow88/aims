<?php

namespace Modules\KPP\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KppRuleType extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function rules(): HasMany
    {
        return $this->HasMany(KppRule::class, 'rule_type_id');
    }
}
