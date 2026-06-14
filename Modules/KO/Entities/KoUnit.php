<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class KoUnit extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'created_at' => 2,
            //
        ],
        'joins' => [
            //
        ]
    ];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\UnitFactory::new();
    }

    public function koSpipUnit(): BelongsTo
    {
        return $this->belongsTo(KoSpipUnit::class);
    }

    public function koBrand(): BelongsTo
    {
        return $this->belongsTo(KoBrand::class);
    }
}
