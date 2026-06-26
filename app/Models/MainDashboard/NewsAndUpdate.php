<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperNewsAndUpdate
 */
class NewsAndUpdate extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_news_and_update";
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'attc',
        'url',
        'blob_url',
        'blob_response',
        'visible'

    ];

    protected $hidden = [
        'user_id',
    ];
}
