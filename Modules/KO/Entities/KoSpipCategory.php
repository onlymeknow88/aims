<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KoSpipCategory extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\SpipCategoryFactory::new();
    }

    public function koBrands(): HasMany
    {
        return $this->hasMany(KoBrand::class)->withTrashed();
    }
}
