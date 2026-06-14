<?php

namespace Modules\CSMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CsmsChecklist extends Model
{
    use HasUuids;
    protected $guarded = [];

    // protected $table = 'csms_checklists';

    // public function files(): HasMany
    // {
    //     return $this->HasMany(CsmsChecklistAttacment::class, 'checklist_id');
    // }

    public function files()
    {
        return $this->hasMany(CsmsChecklistAttacment::class, 'csms_checklist_id');
    }
}
