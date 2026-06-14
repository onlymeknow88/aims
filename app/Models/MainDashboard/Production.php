<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperPerformance
 */
class Production extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_production";
    protected $fillable = [
        'user_id',
        'visible',
        'month',
        'coal_shiping',
        'waste_removal',
        'coal_mining',
        'coal_hauling',
        'coal_barged',
    ];

    protected $hidden = [
        'user_id',
    ];
}
