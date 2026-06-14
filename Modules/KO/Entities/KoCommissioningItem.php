<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KoCommissioningItem extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoCommissioningItemFactory::new();
    }

    public function koCommissioning(): BelongsTo
    {
        return $this->belongsTo(KoCommissioning::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(KoCommissioningItemAttachment::class, 'item_id');
    }
}
