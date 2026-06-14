<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapDepartmentCodes extends Model
{
    use HasUuids;
    protected $table = "department_codes";
    protected $fillable = [
        'code',
        'type'
    ];

    public function dataDepartment()
    {
        return $this->hasOne(SapDepartments::class, 'code', 'code');
    }
}
