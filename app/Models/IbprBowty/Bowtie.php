<?php

namespace App\Models\IbprBowty;

use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtie
 */
class Bowtie extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie';

    public function pja()
    {
        return $this->belongsTo(User::class, 'pja_id');
    }

    public function ohs()
    {
        return $this->belongsTo(User::class, 'ohs_id');
    }

    public function pjs()
    {
        return $this->belongsTo(User::class, 'pjs_id');
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

    public function contractor()
    {
        return $this->belongsTo(Company::class, 'contractor_id');
    }

    public function sub_contractor()
    {
        return $this->belongsTo(Company::class, 'sub_contractor_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function teams()
    {
        return $this->hasMany(BowtieTeam::class, 'bowtie_id');
    }

    public function events()
    {
        return $this->hasMany(BowtieEvent::class, 'bowtie_id');
    }

    public function cca()
    {
        return $this->hasMany(BowtieCca::class, 'bowtie_id');
    }

    public function performances()
    {
        return $this->hasMany(BowtiePerformanceStandard::class, 'bowtie_id');
    }

    public function loss_calculations()
    {
        return $this->hasMany(BowtieLossCalculation::class, 'bowtie_id');
    }

    public function activity()
    {
        return $this->hasMany(BowtieActivity::class, 'bowtie_id');
    }
}
