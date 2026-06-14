<?php

namespace App\Models\Mcu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProvider
 */
class Provider extends Model
{
    use HasFactory;

    protected $table = 'mcu_provider';
    protected $guarded = ['id'];
}
