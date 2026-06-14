<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoBrand extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoBrandFactory::new();
    }

    public function koSpipCategory(): BelongsTo
    {
        return $this->belongsTo(KoSpipCategory::class);
    }
}
