<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class IadlFormBowtie extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'iadl_form_risk';

    public function pica()
    {
        return $this->hasMany(Pica::class, 'iadl_form_id');
    }

}
