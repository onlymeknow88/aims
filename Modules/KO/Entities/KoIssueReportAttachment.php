<?php

namespace Modules\KO\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KoIssueReportAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoIssueReportAttachmentFactory::new();
    }

    public function KoIssueReport(): BelongsTo
    {
        return $this->belongsTo(IssueReport::class);
    }
}
