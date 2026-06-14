<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KO\Entities\KoCommissioningHeader;

class KoSpipUnit extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'attachment_field' => 'array'
    ];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\SpipUnitFactory::new();
    }

    public function koSpipType(): BelongsTo
    {
        return $this->belongsTo(KoSpipType::class);
    }

    public function koCommisioningHeaders(): HasMany
    {
        return $this->hasMany(KoCommissioningHeader::class);
    }
}
