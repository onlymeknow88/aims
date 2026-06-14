<?php

namespace Modules\KPP\Entities;

use App\Enums\CompanyType;
use App\Enums\KPP\ExtractionStatus;
use App\Models\Company;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;


class KppRule extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'rules.date' => 2,
            //
        ],
        'joins' => [
            //
        ]
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function agencyAuthority(): BelongsTo
    {
        return $this->belongsTo(KppAgencyAuthority::class, 'agency_authority_id')->withTrashed();
    }

    public function ruleType(): BelongsTo
    {
        return $this->belongsTo(KppRuleType::class, 'rule_type_id')->withTrashed();
    }

    public function oldRule(): BelongsTo
    {
        return $this->belongsTo(KppRule::class, 'parent_rule_id');
    }

    public function obediences(): HasMany
    {
        return $this->hasMany(KppObedience::class, 'rule_id');
    }

    public function internalObediences()
    {
        $internalIds = Company::where('type', CompanyType::Internal()->value)->pluck('id');
        $obediences = KppObedience::whereIn('company_id', $internalIds)->where('rule_id', $this->id)->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }

    public function contractorObediences()
    {
        $internalIds = Company::where('type', CompanyType::Contractor()->value)->pluck('id');
        $obediences = KppObedience::whereIn('company_id', $internalIds)->where('rule_id', $this->id)->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }

    public function subcontractorObediences()
    {
        $internalIds = Company::where('type', CompanyType::SubContractor()->value)->pluck('id');
        $obediences = KppObedience::whereIn('company_id', $internalIds)->where('rule_id', $this->id)->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }

    public function childSubcontractorObediences()
    {
        $subcontractorIds = Company::where('type', CompanyType::SubContractor()->value)
            ->where('parent_company_id', Auth::user()->department->company->id)
            ->pluck('id');
        $obediences = KppObedience::whereIn('company_id', $subcontractorIds)->where('rule_id', $this->id)->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }

    public function files(): HasMany
    {
        return $this->HasMany(KppRuleFile::class, 'rule_id');
    }

    public function scopeExceptDraft($query)
    {
        return $query->where('is_draft', 0);
    }

    public function scopeOnlyDraft($query)
    {
        return $query->where('is_draft', 1);
    }

    public function getArticleTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)->groupBy('article_id')->get()->count();
    }

    public function getExtractionTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)->count();
    }

    public function getCompliedExtractionTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)
            ->where('status', ExtractionStatus::Complied()->value)
            ->count();
    }

    public function getNotComplyExtractionTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)
            ->where('status', ExtractionStatus::NotComply()->value)
            ->count();
    }

    public function getNotApplicableExtractionTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)
            ->where('status', ExtractionStatus::NotApplicable()->value)
            ->count();
    }

    public function getInProgressExtractionTotalAttribute()
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)
            ->whereIn('status', [ExtractionStatus::Checking()->value, ExtractionStatus::InReview()->value, ExtractionStatus::UnderRevision()->value])
            ->count();
    }

    public function getComplianceLevelTotal($level)
    {
        $obedience_ids = KppObedience::where('rule_id', $this->id)->pluck('id');
        return KppExtraction::whereIn('obedience_id', $obedience_ids)
            ->where('compliance_level', $level)
            ->count();
    }
}
