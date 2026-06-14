<?php

namespace Modules\Pica\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PicaAuditor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Pica\Database\factories\PicaAuditorFactory::new();
    }
}
