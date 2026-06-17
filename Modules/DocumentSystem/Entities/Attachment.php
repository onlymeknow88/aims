<?php

namespace Modules\DocumentSystem\Entities;

use App\Services\DocumentSystemService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Attachment extends Model
{
    use HasUuids;

    protected $table = 'document_system_attachments';

    protected $fillable = [
        'document_id',
        'file_name',
        'file_size',
        'file_type',
        'path',
        'blob_url',
        'blob_response',
        'status',
    ];

    protected $guarded = [];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function iconFileType(): Attribute
    {
        $service = new DocumentSystemService();
        $file_icon = $service->define_file_icon($this->file_type);
        return Attribute::make(
            get: fn () => $file_icon
        );
    }

    public function fileSizeMb(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return round($attributes['file_size'] / (1024 * 1024), 2) . ' Mb';
            }
        );
    }
}
