<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AuditSubCriteriaPoint extends Model
{
    use HasUuids;
    protected $guarded = [];
}
