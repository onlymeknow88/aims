<?php

namespace Modules\Kplh\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InspectionData extends Model
{
    use HasUuids;

    protected $table = 'kplh_inspection_data';

    protected $guarded = [];

    public function label()
    {
        return $this->belongsTo(KplhLabel::class, 'label_id');
    }

    public function risks()
    {
        return $this->belongsTo(InspectionRisks::class, 'label_id');
    }
}
