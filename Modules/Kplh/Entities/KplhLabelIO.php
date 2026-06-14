<?php

namespace Modules\Kplh\Entities;

use App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KplhLabelIO extends Model
{
    // use HasUuids;

    protected $table = 'kplh_label_io';

    protected $guarded = [];

    public function label()
    {
        return $this->belongsTo(KplhLabel::class, 'label_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
