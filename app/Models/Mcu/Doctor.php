<?php

namespace App\Models\Mcu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDoctor
 */
class Doctor extends Model
{
    use HasFactory;

    protected $table = 'mcu_doctor';
    protected $guarded = ['id'];
}
