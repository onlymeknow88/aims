<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieLossCalculationDetail
 */
class BowtieLossCalculationDetail extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie_loss_calculation_detail';
    
}