<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperFieldLeadershipMember
 */
class FieldLeadershipMember extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
