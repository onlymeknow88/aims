<?php

namespace Modules\DocumentSystem\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JsaDocumentPeople extends Model
{
    use HasFactory, HasUuids;

    /**
     * Consant variable
     */
    const USER_INSIDE_OFFICE = 1;
    const USER_OUTSIDE_OFFICE = 2;

    protected  $fillable = [
        'document_id',
        'email',
        'user_id',
        'type',
        'is_notify_email',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(JsaDocument::class, 'document_id');
    }
}
