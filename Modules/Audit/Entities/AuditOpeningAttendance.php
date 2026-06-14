<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditOpeningAttendance extends Model
{
    use HasUuids;

    protected $guarded = [];

}
