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
 * @mixin IdeHelperIbpr
 */
class Ibpr extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function pja()
    {
        return $this->belongsTo(User::class, 'pja_id');
    }

    public function pjo()
    {
        return $this->belongsTo(User::class, 'pjo_id');
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
        return $this->hasMany(IbprTeam::class, 'ibpr_id');
    }

    public function forms()
    {
        return $this->hasMany(IbprForm::class, 'ibpr_id');
    }
}
