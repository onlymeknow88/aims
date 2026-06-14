<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KoQrRequestFiles extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoQrRequestFilesFactory::new();
    }

    public function KoProposal(): BelongsTo
    {
        return $this->belongsTo(KoProposal::class);
    }
}
