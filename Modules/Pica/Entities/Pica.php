<?php

namespace Modules\Pica\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pica extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'source',
        'source_id',
        'picaable_id',
        'picaable_type',
    ];

    public function picaable()
    {
        return $this->morphTo();
    }
}
