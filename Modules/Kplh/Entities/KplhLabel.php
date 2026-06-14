<?php

namespace Modules\Kplh\Entities;

use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pica\Entities\Pica;
use Modules\Pica\Entities\PicaDocument;
use Modules\Pica\Entities\PicaFile;
use Nicolaslopezj\Searchable\SearchableTrait;

class KplhLabel extends Model
{
    use HasUuids, SoftDeletes, SearchableTrait;

    protected $table = 'kplh_label';

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'companies.company_name' => 10,
            'area_locations.name' => 5,
            'kplh_label.date' => 2,
        ],
        'joins' => [
            'companies' => ['kplh_label.company_id', 'companies.id'],
            'departments' => ['kplh_label.department_id', 'departments.id'],
            'sections' => ['kplh_label.section_id', 'sections.id'],

        ],
    ];

    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    public function ccow()
    {
        return $this->belongsTo(Company::class, 'ccow_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function pja()
    {
        return $this->belongsTo(AreaManager::class, 'pja_id');
    }

    public function ktt()
    {
        return $this->belongsTo(User::class, 'ktt_id');
    }

    public function inspection_officers()
    {
        return $this->hasMany(KplhLabelIO::class, 'label_id');
    }

    public function inspection_data()
    {
        return $this->hasMany(InspectionData::class, 'label_id');
    }

    public function areaLocation()
    {
        return $this->belongsTo(AreaLocation::class, 'area_location_id');
    }

// PICA
    public function pica()
    {
        return $this->belongsTo(PicaDocument::class, 'pica_id');
    }

    public function picaFiles()
    {
        return $this->hasMany(PicaFile::class, 'pica_id');
    }

    public function picaable()
    {
        return $this->morphOne(Pica::class, 'picaable');
    }

}
