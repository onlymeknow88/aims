<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
//use \Awobaz\Compoships\Compoships;

class SapMonthlyEmployee extends Model
{
    use HasUuids, SoftDeletes;
    //use Compoships;

    protected $table = "sap_monthly_employee";
    protected $fillable = [
        'user_id',
        'category_id',
        'slug',
        'jde',
        'name',
        'position',
        'dept',
        'company_name',
        'grade',
        'grade_code',
        'code',
        'id_number',
        'department_id',
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
        return $this->hasOne('Modules\Sap\Entities\SapMonthlyActual', 'user_id', 'user_id');
        //return $this->hasOne('Modules\Sap\Entities\SapMonthlyActual', ['user_id', 'grade_code'], ['user_id', 'grade_code']);
    }
}
