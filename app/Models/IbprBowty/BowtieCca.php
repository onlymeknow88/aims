<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtieCca
 */
class BowtieCca extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie_cca';

    public function events()
    {
        return $this->belongsToMany(BowtieEvent::class);
    }
}
