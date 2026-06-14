<?php

namespace Modules\FieldLeadership\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldLeadershipActivityFile extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function activity()
    {
        return $this->belongsTo(FieldLeadershipActivity::class, 'fl_activity_id');
    }
}
