<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieLossCalculation
 */
class BowtieLossCalculation extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie_loss_calculation';

    public function event()
    {
        return $this->belongsTo(BowtieEvent::class, 'event_id');
    }

    public function details()
    {
        return $this->hasMany(BowtieLossCalculationDetail::class, 'loss_calculation_id');
    }
}