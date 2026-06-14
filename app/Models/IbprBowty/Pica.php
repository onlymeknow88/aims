<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pica extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'pica_ibpr';

    public function form()
    {
        return $this->belongsTo(IbprForm::class, 'ibpr_form_id');
    }

    public function ibprRisk()
    {
        return $this->belongsTo(IbprFormBowtie::class, 'ibpr_form_risk_id');
    }

    public function formIadl()
    {
        return $this->belongsTo(IadlForm::class, 'iadl_form_id');
    }
}
