<?php

namespace Modules\DocumentSystem\Entities;

use App\Services\DocumentSystemService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityAttachment extends Model
{
    use HasFactory, HasUuids;

    /**
     * Define writable column
     */
    protected $fillable = [
        'activity_id',
        'path',
        'file_size',
        'file_type',
        'name',
    ];

    /**
     * Define table
     */
    protected $table = 'document_system_activities_attachments';

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function iconFileType(): Attribute
    {
        $service = new DocumentSystemService();
        $file_icon = $service->define_file_icon($this->file_type);
        return Attribute::make(
            get: fn () => $file_icon
        );
    }
}
