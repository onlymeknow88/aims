<?php

namespace Modules\Mcu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'mcu_doctor';
    protected $guarded = ['id'];
}
