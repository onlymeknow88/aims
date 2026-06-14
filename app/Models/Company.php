<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCompany
 */
class Company extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $guarded = [];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'company_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_company_id');
    }

    public function children(): HasMany
    {
        return $this->HasMany(self::class, 'parent_company_id');
    }
}
