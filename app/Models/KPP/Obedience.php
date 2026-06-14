<?php

namespace App\Models\KPP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperObedience
 */
class Obedience extends Model
{
    use HasFactory, HasUuids;
}
