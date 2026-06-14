<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperFieldLeadershipRisk
 */
class FieldLeadershipRisk extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }

    public function files()
    {
        return $this->hasMany(FieldLeadershipRiskFile::class, 'fl_risk_id');
    }

    public function category()
    {
        return $this->belongsTo(FieldLeadershipCategory::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(FieldLeadershipKtaAndTta::class, 'type_id');
    }

    public function potency()
    {
        return $this->belongsTo(FieldLeadershipPotencyAndConsequnce::class, 'potency_id');
    }
}
