<?php

namespace Modules\DocumentSystem\Entities;

use App\Models\Department;
use App\Models\User;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Mapping;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class JsaDocument extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    const ACTIVE = 1;
    const DRAFT = 2;
    const EXPIRED = 3;
    const OBSOLATE = 4;

    protected $fillable = [
        'department_id',
        'department_code_id',
        'user_id',
        'status',
        'title',
        'description',
        'document_number',
        'doc_created',
        'detail_location',
        'prefix_code',
        'history_revision',
        'parent_document',
        'is_obsolate',
        'revision',
        'related_document_id',
    ];

    protected $searchable = [
        'columns' => [
            'jsa_documents.title' => 10,
            'jsa_documents.document_number' => 10,
            'jsa_documents.detail_location' => 10,
            'departments.name' => 10,
            'users.name' => 10,
        ],
        'joins' => [
            'departments' => ['jsa_documents.department_id', 'departments.id'],
            'users' => ['jsa_documents.user_id', 'users.id'],
        ],
    ];

    public function peoples(): HasMany
    {
        return $this->hasMany(JsaDocumentPeople::class, 'document_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(JsaDocumentActivity::class, 'document_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(JsaDocumentAttachment::class, 'document_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function scopeExceptDraft($query)
    {
        return $query->where('status', '!=', self::DRAFT);
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
                    case self::EXPIRED:
                        return '<span class="cancel">Expired</span>';
                    case self::DRAFT:
                        return '<span class="pending">Draft</span>';
                    case self::OBSOLATE:
                        return '<span class="default">Obsolate</span>';
                }
            }
        );
    }

    public function fixHistoryRevision(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['revision']) {
                    $history = json_decode($attributes['history_revision'], TRUE);
                    unset($history[0]);
                    $history = array_values($history);
                    $history = array_merge($history, [$attributes['doc_created']]);
                    $history = collect($history)->map(function ($item) {
                        return date('d/m/Y', strtotime($item));
                    })->all();
                } else {
                    $history = [];
                }

                return $history;
            }
        );
    }

    public function relatedDocumentNumber(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $res = null;
                if ($attributes['related_document_id']) {
                    $document = JsaDocument::select('document_number')
                        ->find($attributes['related_document_id']);
                    if ($document) {
                        $res = $document->document_number;
                    }
                }

                return $res;
            }
        );
    }

    public function expired(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attribute) {
                return Carbon::parse($attribute['doc_created'])
                    ->addYear(1)
                    ->format('d F Y');
            }
        );
    }
}
