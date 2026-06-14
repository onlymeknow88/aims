<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapSetup extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "sap_setup";
    protected $fillable = [
        'user_id',
        'category_id',
        'slug',
        'available',
        'safety_accountability_progam',
        'dept_head',
        'foreman_supervisor_sechead',
        'employee',
        'year'
    ];

    public function SapSetupCategory()
    {
        return $this->hasOne(SapSetupCategory::class, 'id', 'category_id');
    }
}
