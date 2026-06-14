<?php

namespace Modules\DocumentSystem\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JsaDocumentActivity extends Model
{
    use HasFactory, HasUuids;

    protected  $fillable = [
        'document_id',
        'user_id',
        'status_document',
        'description',
        'attachments',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(JsaDocument::class, 'document_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
