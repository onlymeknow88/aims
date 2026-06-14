<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperK3lhAward
 */
class K3lhAward extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_k3lh_award";
    protected $fillable = [
        'user_id',
        'rank',
        'company',
        'grade',
        'visible',
        'month'
    ];

    protected $hidden = [
        'user_id',
    ];
}
