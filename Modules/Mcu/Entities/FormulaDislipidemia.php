<?php

namespace Modules\Mcu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDislipidemia extends Model
{
    use HasFactory;

    protected $table = 'mcu_formula_dislipidemia';
    protected $guarded = ['id'];
}
