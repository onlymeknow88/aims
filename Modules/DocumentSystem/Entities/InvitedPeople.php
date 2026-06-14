<?php

namespace Modules\DocumentSystem\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitedPeople extends Model
{
    use HasFactory, HasUuids;

    /**
     * Consant variable
     */
    const USER_INSIDE_OFFICE = 1;
    const USER_OUTSIDE_OFFICE = 2;

    /**
     * Define table name
     */
    protected $table = 'document_system_invited_people';

    /**
     * Define writeable column
     */
    protected $fillable = [
        'user_id',
        'document_id',
        'user_type',
        'is_notify_email',
        'email',
    ];

    // begin::relations
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
    // end::relations
}
