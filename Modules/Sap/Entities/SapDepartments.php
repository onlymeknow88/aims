<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapDepartments extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "departments";
    protected $fillable = [];

    public function employeeList()
    {
        return $this->hasMany(SapEmployees::class, 'department_id', 'id');
    }

    public function userList()
    {
        return $this->hasMany('App\Models\User', 'department_id', 'id');
    }
}
