<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KoCommissioningHeader extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\CommisioningHeaderFactory::new();
    }

    public function koSpipUnit(): BelongsTo
    {
        return $this->belongsTo(KoSpipUnit::class);
    }

    public function koCommisioningFields(): HasMany
    {
        return $this->hasMany(KoCommissioningField::class);
    }
}
