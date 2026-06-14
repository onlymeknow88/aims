<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieEvent
 */
class BowtieEvent extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function bowtie()
    {
        return $this->belongsTo(Bowtie::class, 'bowtie_id');
    }

    public function cmf()
    {
        return $this->hasMany(BowtieEventCmf::class, 'event_id');
    }


    public function reasons()
    {
        return $this->hasMany(BowtieEventReason::class, 'event_id');
    }

    public function cmf_repair()
    {
        return $this->hasMany(BowtieEventCmfRepair::class, 'event_id');
    }

    public function imm()
    {
        return $this->hasMany(BowtieEventImm::class, 'event_id');
    }

    public function imm_repair()
    {
        return $this->hasMany(BowtieEventImmRepair::class, 'event_id');
    }
}
