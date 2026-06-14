<?php

namespace Modules\Pica\Entities;

use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

class PicaDocument extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $fillable = [
        'identity_id',
        'source',
        'type',
        'date',
        'ccow_id',
        'company_id',
        'section_id',
        'location_id',
        'location_detail',
        'company_detail',
        'pja_id',
        'pjo_id',
        'auditor',
        'non_compliance',
        'non_compliance_root_cause',
        'corrective_action',
        'target_settlement_date',
        'settlement_date',
        'remarks',
        'requested',
        'published',
        'status'
    ];

    protected $searchable = [
        'columns' => [
            'pica_documents.identity_id' => 10,
            'pica_documents.type' => 10,
            'pica_documents.source' => 10,
            'companies.company_name' => 10,
            'sections.name' => 6,
            'area_locations.name' => 5,
        ],
        'joins' => [
            'companies' => ['pica_documents.company_id', 'companies.id'],
            'sections' => ['pica_documents.section_id', 'sections.id'],
            'area_locations' => ['pica_documents.location_id', 'area_locations.id'],
        ],
    ];

    public function pica()
    {
        return $this->morphOne(Pica::class, 'picaable');
    }

    public function ccow()
    {
        return $this->belongsTo(Company::class, 'ccow_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function areaLocation()
    {
        return $this->belongsTo(AreaLocation::class, 'location_id');
    }

    public function pja()
    {
        return $this->belongsTo(AreaManager::class, 'pja_id');
    }

    public function pjo()
    {
        return $this->belongsTo(User::class, 'pjo_id');
    }

    public function activities()
    {
        return $this->hasMany(PicaActivity::class, 'pica_id');
    }

    public function picaFiles()
    {
        return $this->hasMany(PicaFile::class, 'pica_id');
    }
}
