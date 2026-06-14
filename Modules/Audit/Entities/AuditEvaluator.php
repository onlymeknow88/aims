<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AuditEvaluator extends Model
{
    use HasUuids;

    protected $guarded = [];
}
