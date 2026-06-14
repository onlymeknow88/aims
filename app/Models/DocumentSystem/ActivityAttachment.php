<?php

namespace App\Models\DocumentSystem;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperActivityAttachment
 */
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
}
