<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KoCommissioning extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoCommissioningFactory::new();
    }

    public function koProposal(): BelongsTo
    {
        return $this->belongsTo(KoProposal::class);
    }

    public function koCommissioningItem(): HasMany
    {
        return $this->hasMany(KoCommissioning::class);
    }
}
