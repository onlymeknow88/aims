<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperFieldLeadershipRiskFile
 */
class FieldLeadershipRiskFile extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadershipRisk()
    {
        return $this->belongsTo(FieldLeadershipRisk::class, 'fl_risk_id');
    }
}
