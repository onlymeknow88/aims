<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperGeneral
 */
class General extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_general";
    protected $fillable = [
        'user_id',

        'project_to_date',
        'project_to_date_mark',

        'manhours',
        'manhours_mark',

        'day_after_last_lti',
        'day_after_last_lti_mark',
        
        'manpower',
        'manpower_mark',

        'month',
        'visible'
    ];

    protected $hidden = [
        'user_id',
    ];
}
