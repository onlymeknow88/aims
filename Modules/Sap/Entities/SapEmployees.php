<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapEmployees extends Model
{
    use HasUuids;
    protected $table = "employees";
    protected $fillable = [
        'id_number',
        'department_id',
        'grade'
    ];

    public function monthlyList()
    {
        return $this->hasMany(SapMonthly::class, 'employee_id', 'id');
    }

    public function employeeTarget()
    {
        return $this->hasOne(SapMonthlyTarget::class, 'employee_id', 'id');
    }

    public function employeeActual()
    {
        return $this->hasOne(SapMonthlyActual::class, 'employee_id', 'id');
    }

    public function userList()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }
}
