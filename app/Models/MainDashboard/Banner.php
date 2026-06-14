<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperBanner
 */
class Banner extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_banner";
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'attc',
        'url',
        'visible'
    ];

    protected $hidden = [
        'user_id',
    ];
}
