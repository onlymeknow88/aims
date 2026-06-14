<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapMonthlyCategory extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "sap_monthly_category";
    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'description',
        'available',
        'code',
        'department_id',
    ];

    public function employeeList()
    {
        return $this->hasMany(SapMonthlyEmployee::class, 'category_id', 'id');
    }
}
