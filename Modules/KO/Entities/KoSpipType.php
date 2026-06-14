<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KoSpipType extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\SpipTypeFactory::new();
    }

    public function koSpipCategory(): BelongsTo
    {
        return $this->belongsTo(KoSpipCategory::class);
    }
}
