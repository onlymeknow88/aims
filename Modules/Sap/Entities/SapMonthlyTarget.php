<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapMonthlyTarget extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "sap_monthly_target";
    protected $fillable = [
        'user_id',
        'employee_id',
        'module_name',
        'value',
        'employee_number',
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
    ];
}
