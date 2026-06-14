<?php

namespace Modules\Mcu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaBloodPressure extends Model
{
    use HasFactory;

    protected $table = 'mcu_formula_blood_pressure';
    protected $guarded = ['id'];

}
