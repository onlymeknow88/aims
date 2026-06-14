<?php

namespace Modules\FieldLeadership\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldLeadershipQuestionPto extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }
}
