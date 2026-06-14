<?php

namespace Modules\KPP\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KppExtractionTransaction extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function extraction()
    {
        return $this->belongsTo(KppExtraction::class, 'extraction_id');
    }
}
