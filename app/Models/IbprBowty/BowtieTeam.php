<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieTeam
 */
class BowtieTeam extends Model
{
    use HasUuids;
    protected $guarded = [];


}
