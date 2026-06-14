<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieActivity
 */
class BowtieActivity extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie_activity';
}