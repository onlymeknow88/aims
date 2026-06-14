<?php

namespace App\Models\Mcu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFormulaDislipidemia
 */
class FormulaDislipidemia extends Model
{
    use HasFactory;

    protected $table = 'mcu_formula_dislipidemia';
    protected $guarded = ['id'];
}
