<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class IbprFormBowtie extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'ibpr_form_risk';

}
