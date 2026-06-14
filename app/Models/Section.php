<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSection
 */
class Section extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function area_managers(): HasMany
    {
        return $this->hasMany(AreaManager::class, 'section_id');
    }

    public function area_locations(): HasMany
    {
        return $this->hasMany(AreaLocation::class, 'section_id');
    }
}
