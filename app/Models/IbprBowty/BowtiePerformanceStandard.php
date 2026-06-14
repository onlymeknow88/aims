<?php

namespace App\Models\IbprBowty;

use App\Models\Department;
use App\Models\Section;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBowtiePerformanceStandard
 */
class BowtiePerformanceStandard extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'bowtie_performance_standard';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}