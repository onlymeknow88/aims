<?php

namespace Modules\KPP\Entities;

use App\Enums\CompanyType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class KppObedience extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'obediences.date' => 2,
            //
        ],
        'joins' => [
            //
        ]
    ];


    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function rule()
    {
        return $this->belongsTo(KppRule::class, 'rule_id');
    }

    public function emails()
    {
        return $this->hasMany(KppObedienceEmail::class, 'obedience_id');
    }

    public function extractions()
    {
        return $this->hasMany(KppExtraction::class, 'obedience_id');
    }

    public function contractorObediences()
    {
        $companyIds = Company::where('parent_company_id', $this->company_id)
            //->where('type', CompanyType::Contractor()->value)
            ->pluck('id');
        $obediences = KppObedience::whereIn('company_id', $companyIds)->where('rule_id', $this->rule->id)->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }

    public function subcontractorObediences()
    {
        $contractorIds = Company::where('parent_company_id', $this->company_id)
            //->where('type', CompanyType::Contractor()->value)
            ->pluck('id');
        $subcontractorIds = Company::whereIn('parent_company_id', $contractorIds)->where('type', CompanyType::SubContractor()->value)->pluck('id');

        $obediences = KppObedience::whereIn('company_id', $subcontractorIds)
            ->where('rule_id', $this->rule->id)
            ->get();

        return $obediences;
        //return $this->hasMany(KppObedience::class, 'rule_id')->where('');
    }
}
