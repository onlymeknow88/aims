<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperFieldLeadership
 */
class FieldLeadership extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'companies.company_name' => 10,
            'departments.name' => 8,
            'sections.name' => 6,
            'area_locations.name' => 5,
            'field_leaderships.date' => 2,
        ],
        'joins' => [
            'field_leadership_members' => ['field_leaderships.id', 'field_leadership_members.fl_id'],
            // 'companies' => ['field_leaderships.ccow_id', 'companies.id'],
            'companies' => ['field_leaderships.company_id', 'companies.id'],
            'departments' => ['field_leaderships.department_id', 'departments.id'],
            'sections' => ['field_leaderships.section_id', 'sections.id'],
            'area_locations' => ['field_leaderships.area_location_id', 'area_locations.id'],
            'area_managers' => ['field_leaderships.pja_id', 'area_managers.id'],

        ]
    ];

    public function members()
    {
        return $this->hasMany(FieldLeadershipMember::class, 'fl_id');
    }

    public function risks()
    {
        return $this->hasMany(FieldLeadershipRisk::class, 'fl_id');
    }

    public function positives()
    {
        return $this->hasMany(FieldLeadershipPositive::class, 'fl_id');
    }

    public function pja()
    {
        return $this->belongsTo(AreaManager::class, 'pja_id');
    }

    public function pjo()
    {
        return $this->belongsTo(Employee::class, 'pjo_id');
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

    public function areaLocation()
    {
        return $this->belongsTo(AreaLocation::class, 'area_location_id');
    }

    public function questions()
    {
        return $this->hasMany(FieldLeadershipQuestionPto::class, 'fl_id');
    }
}
