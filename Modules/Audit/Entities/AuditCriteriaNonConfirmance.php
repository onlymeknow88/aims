<?php

namespace Modules\Audit\Entities;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditCriteriaNonConfirmance extends Model
{
    use HasUuids;

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            
            $prefix = "NCR-" . date("Y") . "-".$model->audit_sub_criteria->criteria->module->audit->audit_category."-";
            $len = strlen($prefix);
            $config = [
                'table' => 'audit_criteria_non_confirmances',
                'field' => 'non_confirmance_number',
                'length' => $len + 3,
                'prefix' => $prefix,
                "reset_on_prefix_change" => true
            ];
            $model->non_confirmance_number = IdGenerator::generate($config);
            
        });
    }

    public function audit_sub_criteria(): BelongsTo
    {
        return $this->BelongsTo(AuditSubCriteria::class,'audit_sub_criteria_id');
    }

    public function audit_team(): BelongsTo
    {
        return $this->BelongsTo(AuditTeam::class,'audit_team_id');
    }

}
