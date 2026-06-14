<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KoIssueReport extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\BeritaAcaraFactory::new();
    }

    public function koUnit(): BelongsTo
    {
        return $this->belongsTo(KoUnit::class);
    }

    public function koProposal(): BelongsTo
    {
        return $this->belongsTo(KoProposal::class);
    }

    public function koCommissioningField(): BelongsTo
    {
        return $this->belongsTo(KoCommissioningField::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(KoIssueReportAttachment::class);
    }
}
