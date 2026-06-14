<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperFieldLeadershipQuestionPto
 */
class FieldLeadershipQuestionPto extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }
}
