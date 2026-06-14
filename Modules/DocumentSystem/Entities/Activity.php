<?php

namespace Modules\DocumentSystem\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DocumentSystem\DocumentStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasUuids;

    protected $table = 'document_system_activities';

    protected $guarded = [];

    protected $cast = [
        'attachments' => 'array'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ActivityAttachment::class, 'activity_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function attachments(): HasMany
    // {
    //     return $this->hasMany(ActivityAttachment::class, '')
    // }

    public function statusActivity(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['status_document']) {
                    case DocumentStatus::WaitingReview()->value:
                        return DocumentStatus::WaitingReview()->description;
                    case DocumentStatus::Return()->value:
                        return DocumentStatus::Return()->description;
                    case DocumentStatus::RoutingApproval()->value:
                        return DocumentStatus::RoutingApproval()->description;
                    case DocumentStatus::Approved()->value:
                        return DocumentStatus::Approved()->description;
                    case DocumentStatus::Obsolate()->value:
                        return DocumentStatus::Obsolate()->description;
                    case DocumentStatus::Draft()->value:
                        return DocumentStatus::Draft()->description;
                }
            }
        );
    }
}
