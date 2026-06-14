<?php

namespace Modules\Mcu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'mcu_provider';
    protected $guarded = ['id'];
}
