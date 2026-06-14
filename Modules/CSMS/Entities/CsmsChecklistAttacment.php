<?php

namespace Modules\CSMS\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsmsChecklistAttacment extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    protected $table = 'csms_checklist_attachments';

    public function checklist()
    {
        return $this->belongsTo(CsmsChecklist::class, 'csms_checklist_id');
    }
}
