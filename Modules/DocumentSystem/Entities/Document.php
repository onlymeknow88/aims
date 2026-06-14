<?php

namespace Modules\DocumentSystem\Entities;

use App\Models\AreaManager;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DocumentSystem\DocumentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Document extends Model
{
    use HasUuids, SoftDeletes, SearchableTrait;

    const WAITNG_REVIEW = 1;
    const DRAFT = 2;
    const ROOTING_REVIEW = 3;
    const ON_REVISION = 4;
    const ACTIVE = 5;
    const PREPARE_ROOTING_REVIEW = 6;
    const EXPIRED = 7;
    const OBSOLATE = 8;

    const SOP_DOC_TYPE = 1;
    const TS_DOC_TYPE = 2;
    const MN_DOC_TYPE = 3;
    const WIN_DOC_TYPE = 4;
    const FORM_DOC_TYPE = 5;

    protected $table = 'document_system_documents';

    protected $fillable = [
        'department_id',
        'department_code_id',
        'mapping_id',
        'area_manager_id',
        'user_id',
        'related_people',
        'upload_type',
        'document_level',
        'status',
        'revision',
        'title',
        'description',
        'sop_number',
        'sop_add_win',
        'sop_add_form',
        'document_number',
        'prefix_code',
        'file_path',
        'uncontrolled_file_path',
        'doc_created',
        'related_document_id',
        'created_by',
        'parent_document',
        'history_revision',
        'parent_document',
        'is_obsolate',
    ];

    protected $guarded = [];

    protected $cast = [
        'related_people' => 'array'
    ];

    protected $searchable = [
        'columns' => [
            'document_system_documents.sop_number' => 10,
            'document_system_documents.sop_add_win' => 10,
            'document_system_documents.sop_add_form' => 10,
            'document_system_documents.document_number' => 10,
            'document_system_documents.prefix_code' => 10,
            'document_system_documents.title' => 8,
            'departments.name' => 8,
            'users.name' => 8,
        ],
        'joins' => [
            'departments' => ['document_system_documents.department_id', 'departments.id'],
            'users' => ['document_system_documents.user_id', 'users.id'],
        ]
    ];

    public static function availableStatus()
    {
        return [
            self::WAITNG_REVIEW => trans('global.waiting_review'),
            self::DRAFT => trans('global.draft'),
            self::ROOTING_REVIEW => trans('global.rooting_approval'),
            self::ON_REVISION => trans('global.revision'),
            self::ACTIVE => trans('global.active_document'),
            self::PREPARE_ROOTING_REVIEW => trans('global.preparing'),
        ];
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'document_id');
    }

    public function peoples(): HasMany
    {
        return $this->hasMany(InvitedPeople::class, 'document_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'document_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function mapping()
    {
        return $this->belongsTo(Mapping::class, 'mapping_id');
    }

    public function areaManager()
    {
        return $this->belongsTo(AreaManager::class, 'area_manager_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function relatedDocumentNumber(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $res = null;
                if ($attributes['related_document_id']) {
                    $document = Document::select('sop_number', 'sop_add_win', 'sop_add_form', 'document_number', 'document_level', 'department_id', 'prefix_code')
                        ->find($attributes['related_document_id']);
                    $res = $document->fixDocumentNumber;
                }

                return $res;
            }
        );
    }

    public function documenttype(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attribute) {
                switch ($attribute['document_level']) {
                    case self::SOP_DOC_TYPE:
                        return trans('global.sop');

                    case self::WIN_DOC_TYPE:
                        return 'Working Instruction';

                    case self::FORM_DOC_TYPE:
                        return 'Form';

                    case self::TS_DOC_TYPE:
                        return trans('global.ts');

                    case self::MN_DOC_TYPE:
                        return trans('global.manual');

                    default:
                        return '-';
                }
            }
        );
    }

    public function expired(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attribute) {
                return Carbon::parse($attribute['doc_created'])
                    ->addYear(2)
                    ->format('d F Y');
            }
        );
    }

    public function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['status']) {
                    case self::WAITNG_REVIEW:
                        return '<span class="pending">Waiting Review</span>';
                    case self::ON_REVISION:
                        return '<span class="cancel">Revision</span>';
                    case self::ROOTING_REVIEW:
                        return '<span class="done">Rooting Approval</span>';
                    case self::ACTIVE:
                        return '<span class="done">Active</span>';
                    case self::PREPARE_ROOTING_REVIEW:
                        return '<span class="default">Preparing</span>';
                    case self::EXPIRED:
                        return '<span class="cancel">Expired</span>';
                    case self::DRAFT:
                        return '<span class="pending">Draft</span>';
                    case self::OBSOLATE:
                        return '<span class="default">Obsolate</span>';
                        // case DocumentStatus::Obsolate()->value :
                        //     return '<span class="badge bg-success">'.DocumentStatus::Obsolate()->description.'</span>';
                        // case DocumentStatus::Draft()->value :
                        //     return '<span class="badge bg-warning">'.DocumentStatus::Draft()->description.'</span>';

                }
            }
        );
    }

    public function reviewable(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['status'] == DocumentStatus::WaitingReview()->value) {
                    return true;
                }

                return false;
            }
        );
    }

    public function firstDocCreated(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['revision']) {
                    $history = json_decode($attributes['history_revision'], TRUE);
                    return !empty($history) ? $history[0] : [];
                } else {
                    return $attributes['doc_created'];
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

    public function fixDocumentNumber(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $res = '-';
                if ($attributes['prefix_code']) {
                    $department = Department::select('id', 'code', 'company_id')
                        ->with('company:id,document_code')
                        ->find($this->department_id);
                    $department_code = $department->code;
                    $company_code = $department->company->document_code;
                    $prefix = $attributes['prefix_code'];

                    if ($this->document_level == self::SOP_DOC_TYPE || $this->document_level == self::WIN_DOC_TYPE || $this->document_level == self::FORM_DOC_TYPE) {
                        $res = $prefix . $this->sop_number;
                        if ($this->sop_add_win) {
                            $res = $prefix . $this->sop_add_win;
                        }
                        if ($this->sop_add_form) {
                            $res = $prefix . $this->sop_add_form;
                        }
                    } else if (
                        $this->document_level == self::MN_DOC_TYPE ||
                        $this->document_level == self::TS_DOC_TYPE
                    ) {
                        $res = $prefix . $this->document_number;
                    }
                }

                if (empty($attributes['sop_number']) && empty($attributes['sop_add_win']) && empty($attributes['sop_add_form'] && empty($attributes['prefix_code']))) {
                    $res = $attributes['document_number'];
                }

                return $res;
            },
        );
    }

    public function documentReplicate()
    {
        $newDocument = $this->replicate();
        $newDocument->related_document_id = $this->id;
        $newDocument->file_path = null;
        $newDocument->uncontrolled_file_path = null;
        $newDocument->doc_created = date('Y-m-d');
        $newDocument->status = self::DRAFT;
        $newDocument->revision = (int) $this->revision + 1;
        $newDocument->save();
    }

    public function scopeIsActive($query)
    {
        return $query->whereIn('status', [self::ACTIVE, self::EXPIRED]);
    }

    public function scopeExceptDraft($query)
    {
        return $query->where('status', '!=', self::DRAFT);
    }

    public function scopeExceptObsolate($query)
    {
        return $query->where('is_obsolate', 0);
    }

    public function scopeIsObsolate($query)
    {
        return $query->where('is_obsolate', 1);
    }
}
