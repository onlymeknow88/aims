<?php

namespace Modules\Mcu\Entities;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Mcu\Entities\Doctor;
use Modules\Mcu\Entities\FormulaBloodPressure;
use Modules\Mcu\Entities\FormulaDislipidemia;
use Modules\Mcu\Entities\Provider;

class MedicalHistory extends Model
{
    use SoftDeletes;
    use HasUuids;
    protected $table = 'mcu_medical_history';
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected function findings(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function staff()
    {
        return $this->belongsTo(Employee::class, 'staff_id');
    }

    public function doctor_spesialist()
    {
        return $this->belongsTo(Doctor::class, 'doctor_spesialist_id');
    }

    public function formula_data()
    {
        return $this->belongsTo(FormulaSettings::class, 'formula_id');
    }

    public function formula_blood_pressure_data()
    {
        return $this->belongsTo(FormulaBloodPressure::class, 'formula_blood_pressure_id');
    }

    public function formula_dislipidemia_data()
    {
        return $this->belongsTo(FormulaDislipidemia::class, 'formula_dislipidemia_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
