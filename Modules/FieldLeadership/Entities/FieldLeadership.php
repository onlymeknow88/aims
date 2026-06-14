<?php

namespace Modules\FieldLeadership\Entities;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

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
            // 'companies' => ['field_leaderships.ccow_id', 'companies.id'],s
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
        return $this->belongsTo(User::class, 'pjo_id');
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

    public function activities()
    {
        return $this->hasMany(FieldLeadershipActivity::class, 'fl_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function pica()
    {
        return $this->morphOne(Pica::class, 'picaable');
    }

    public function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['status']) {
                    case FieldLeadershipType::Open:
                        return '<span class="cancel">Open</span>';
                    case  FieldLeadershipType::Close:
                        return '<span class="done">Close</span>';
                    case  FieldLeadershipType::OnReviewPja:
                        return '<span class="default">On Review PJA</span>';
                    case  FieldLeadershipType::Overdue:
                        return '<span class="cancel">Overdue</span>';
                    case  FieldLeadershipType::OnReviewPica:
                        return '<span class="pending">On Review Pica</span>';
                    case  FieldLeadershipType::OnReviewApproval:
                        return '<span class="pending">On Review Approval</span>';
                }
            }
        );
    }
}
