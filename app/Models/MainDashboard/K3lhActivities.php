<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperK3lhActivities
 */
class K3lhActivities extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_k3lh_activities";
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'attc',
        'url',
        'visible'
    ];

    protected $hidden = [
        'user_id',
    ];
}
