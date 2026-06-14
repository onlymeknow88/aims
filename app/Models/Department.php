<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperDepartment
 */
class Department extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class, 'department_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'department_user');
    }

    public function codes(): HasMany
    {
        return $this->hasMany(DepartmentCode::class, 'department_id');
    }
}
