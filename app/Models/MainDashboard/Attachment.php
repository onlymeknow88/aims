<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSlideshow
 */
class Attachment extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "dashboard_attachment";
    protected $fillable = [
        'user_id',
        'name',
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


//dashboard_attachment