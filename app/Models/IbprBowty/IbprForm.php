<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIbprForm
 */
class IbprForm extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function ibpr()
    {
        return $this->belongsTo(Ibpr::class, 'ibpr_id');
    }

    public function risks()
    {
        return $this->hasMany(IbprFormBowtie::class, 'form_id');
    }

    public function pica()
    {
        return $this->hasMany(Pica::class, 'ibpr_form_id');
    }
}
