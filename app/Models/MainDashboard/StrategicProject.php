<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperStrategicProject
 */
class StrategicProject extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_strategic_project";
    protected $fillable = [
        'user_id',
        'title',
        'visible',
        'slug',
        'date',
        'description',
        'attc',
        'url',
        'blob_url',
        'blob_response'
    ];

    protected $hidden = [
        'user_id',
    ];
}
