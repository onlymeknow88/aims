<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AuditCategory extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

   
    public static function boot(){
        parent::boot();

        static::creating(function ($issue) {
            $issue->id = Str::uuid(36);
        });
    }
}






