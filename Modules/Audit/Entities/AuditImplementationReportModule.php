<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuditImplementationReportModule extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function detail(): HasOne
    {
        return $this->hasOne(AuditImplementationReportDetail::class,'audit_implementation_report_module_id');
    }
}
