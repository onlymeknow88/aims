<?php

namespace Modules\DocumentSystem\Entities;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class PtwDocument extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    const ACTIVE = 1;
    const INACTIVE = 2;

    protected  $fillable = [
        'department_id',
        'user_id',
        'status',
        'title',
        'description',
        'document_number',
        'doc_created',
        'inactive_at',
        'detail_location',
    ];

    protected $searchable = [
        'columns' => [
            'ptw_documents.title' => 10,
            'ptw_documents.document_number' => 10,
            'ptw_documents.detail_location' => 10,
            'departments.name' => 10,
            'users.name' => 10,
        ],
        'joins' => [
            'departments' => ['ptw_documents.department_id', 'departments.id'],
            'users' => ['ptw_documents.user_id', 'users.id'],
        ],
    ];

    public function peoples(): HasMany
    {
        return $this->hasMany(PtwDocumentPeople::class, 'document_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(PtwDocumentActivity::class, 'document_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(PtwDocumentAttachment::class, 'document_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['status']) {
                    case self::ACTIVE:
                        return '<span class="done">Active</span>';
                    case self::INACTIVE:
                        return '<span class="cancel">Inactive</span>';
                }
            }
        );
    }
}
