<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperContractor
 */
class Contractor extends Model
{
    use HasUuids, HasFactory;
    protected $guarded = [];
}
