<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KoAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoAttachmentFactory::new();
    }

    public function koProposal(): BelongsTo
    {
        return $this->belongsTo(KoProposal::class);
    }
}
