<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
//use \Awobaz\Compoships\Compoships;

class SapMonthlyActual extends Model
{
    use HasUuids, SoftDeletes;
    //use Compoships;

    protected $table = "sap_monthly_actual";
    protected $fillable = [
        'user_id',
        'employee_id',
        'module_name',
        'module_slug',
        'employee_number',
        'employee_name',
        'id_number',
        'grade',
        'grade_code',
        'year',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'total',
    ];
}
