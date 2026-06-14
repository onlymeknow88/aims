<?php

namespace App\Models\DocumentSystem;

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

/**
 * @mixin IdeHelperDocument
 */
class Document extends Model
{
    use HasUuids, SoftDeletes;

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

    protected $table = 'document_system_documents';

    protected $fillable = [
        'department_id',
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
        'history_revision',
        'parent_document',
        'is_obsolate',
    ];

    protected $guarded = [];

    protected $cast = [
        'related_people' => 'array'
    ];

    public static function availableStatus()
    {
        return [
            self::WAITNG_REVIEW => trans('global.waiting_review'),
            self::DRAFT => trans('global.draft'),
            self::ROOTING_REVIEW => trans('global.rooting_approval'),
            self::ON_REVISION => trans('global.revision'),
            self::ACTIVE => trans('global.active_document'),
            self::PREPARE_ROOTING_REVIEW => trans('global.prepare_rooting_approval'),
            self::OBSOLATE => 'Obsolate',
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
                    $document = Document::select('sop_number', 'sop_add_win', 'sop_add_form', 'document_number', 'document_level', 'department_id')
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

                    case self::TS_DOC_TYPE:
                        return trans('global.ts');

                    case self::MN_DOC_TYPE:
                        return trans('global.manual');
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
                        return '<span class="badge bg-warning">Waiting Review</span>';
                    case self::ON_REVISION:
                        return '<span class="badge bg-danger">Revision</span>';
                    case self::ROOTING_REVIEW:
                        return '<span class="badge bg-success">Rooting Approval</span>';
                    case self::ACTIVE:
                        return '<span class="badge bg-success">Active</span>';
                    case self::PREPARE_ROOTING_REVIEW:
                        return '<span class="badge bg-info">Preparing</span>';
                    case self::EXPIRED:
                        return '<span class="badge bg-danger">Expired</span>';
                    case self::DRAFT:
                        return '<span class="badge bg-secondary">Draft</span>';
                    case self::OBSOLATE:
                        return '<span class="badge bg-secondary">Obsolate</span>';
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

    public function fixDocumentNumber(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $department = Department::select('id', 'code', 'company_id')
                    ->with('company:id,document_code')
                    ->find($attributes['department_id']);
                $department_code = $department->code;
                $company_code = $department->company->document_code;
                $prefix = $company_code . '-' . $department_code . '-';

                $res = '-';
                if ($attributes['document_level'] == self::SOP_DOC_TYPE) {
                    $res = $prefix . $this->sop_number;
                } else if ($attributes['document_level'] == self::TS_DOC_TYPE) {
                    if ($this->sop_add_win) {
                        $res = $prefix . $this->sop_add_win;
                    } else if ($this->sop_add_form) {
                        $res = $prefix . $this->sop_add_form;
                    }
                } else if ($attributes['document_level'] == self::MN_DOC_TYPE) {
                    $res = $prefix . $this->document_number;
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

    public function scopeExceptDraft($query)
    {
        return $query->where('status', '!=', self::DRAFT);
    }
}
