<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class IadlForm extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'iadl_forms';
    
    public function iadl()
    {
        return $this->belongsTo(Iadl::class, 'iadl_id');
    }

    public function risks()
    {
        return $this->hasMany(IadlFormBowtie::class, 'form_id');
    }

    public function pica()
    {
        return $this->hasMany(Pica::class, 'iadl_form_id');
    }
}
