<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $dates = ['date_of_birth'];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function field_leadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function companys()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
