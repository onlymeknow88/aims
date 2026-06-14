<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieEventCmfRepair
 */
class BowtieEventCmfRepair extends Model
{
    use HasUuids;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'bowtie_event_repair_cmf';


}
