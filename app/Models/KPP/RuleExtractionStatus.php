<?php

namespace App\Models\KPP;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperRuleExtractionStatus
 */
class RuleExtractionStatus extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];
}
