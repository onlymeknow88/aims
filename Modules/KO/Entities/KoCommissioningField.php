<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KoCommissioningField extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\CommissioningFieldFactory::new();
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(KoCommissioningHeader::class);
    }

    public function koCommissioningItem($ko_commissioning_id): HasOne
    {
        return $this->hasOne(KoCommissioningItem::class)->where('ko_commissioning_id', $ko_commissioning_id);
    }
}
