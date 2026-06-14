<?php

namespace Modules\DocumentSystem\Entities;

use App\Services\DocumentSystemService;
use App\Services\JsaService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JsaDocumentAttachment extends Model
{
    use HasFactory, HasUuids;

    protected  $fillable = [
        'document_id',
        'file_name',
        'file_type',
        'file_size',
        'path',
        'status',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(JsaDocument::class, 'document_id');
    }

    public function iconFileType(): Attribute
    {
        $service = new JsaService();
        $file_icon = $service->define_file_icon($this->file_type);
        return Attribute::make(
            get: fn () => $file_icon
        );
    }
}
