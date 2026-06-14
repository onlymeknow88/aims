<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperPerformance
 */
class Performance extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_performance";
    protected $fillable = [
        'user_id',
        'rkk',
        'cmr',
        'mmr',
        'ssr',
        'asr',
        'month',
        'visible'
    ];

    protected $hidden = [
        'user_id',
    ];
}
