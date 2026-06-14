<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSafetyPerformance
 */
class SafetyPerformance extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_safety_performance";
    protected $fillable = [
        'user_id',
        'aifr',
        'ainfr',
        'lti_fr',
        'lti_sr',
        'month',
        'visible'
    ];

    protected $hidden = [
        'user_id',
    ];
}
