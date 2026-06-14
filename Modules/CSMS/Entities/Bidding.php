<?php

namespace Modules\CSMS\Entities;

use App\Enums\CSMS\CsmsStatus;
use App\Models\BusinessEntity;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CSMS\Enums\BiddingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CSMS\Enums\ServiceCriteria;

class Bidding extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'maker_id',
        'criteria',
        'classification',
        'ccow_id',
        'company_id',
        'parent_id',
        'business_entity_id',
        'company_name',
        'address',
        'company_site',
        'license_number',
        'service_criteria',
        'person_in_charge',
        'status',
        'requested',
        'published',
        'approved_by',
        'questionnaire',
        'risk_category',
        'date',
        'is_obsolate',
        'revision',
        'parent_id',
        'grand_parent_id',
    ];

    protected $casts = [
        'service_criteria' => ServiceCriteria::class,
        'status' => CsmsStatus::class
    ];

    public function ccow(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'ccow_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Bidding::class, 'parent_id');
    }

    public function business_entity(): BelongsTo
    {
        return $this->belongsTo(BusinessEntity::class, 'business_entity_id');
    }

    public function checklists()
    {
        return $this->HasMany(CsmsChecklist::class, 'bidding_id');
    }

    public function parent_company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    public function approved_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function criteriaBadge(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['criteria']) {
                    case CsmsStatus::Bidding:
                        return '<span class="done">Bidding</span>';
                    case  CsmsStatus::PostBidding:
                        return '<span class="done">Post Bidding</span>';
                    case  CsmsStatus::Renewal:
                        return '<span class="default">Renewal</span>';
                    case  CsmsStatus::Inactive:
                        return '<span class="cancel">Inactive</span>';
                }
            }
        );
    }
}
