<?php

namespace Modules\Mcu\Http\Livewire\Patient;

use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Mcu\Entities\MedicalHistory;

class Details extends Component
{
    public $mcu_id;
    public $data;
    public $staff;
    public $mcu_staff_list;
    public $mcu_details;

    public function mount()
    {
        if ($this->mcu_id) {
            $this->data = MedicalHistory::with('employee')->where('id', $this->mcu_id)->first();
        } else {
            $this->data = MedicalHistory::with('employee')->where('employee_id', auth()->user()->employee->id)->first();
        }

        if (!$this->data) {
            // return abort(404);
        } else {
            $this->mcu_staff_list = MedicalHistory::with('employee')->where('employee_id', auth()->user()->employee->id)->get();

            $this->employee_age = Carbon::parse($this->data->employee->date_of_birth)->age;

            $this->file = "" . $this->data->employee_id . "-" . slugify($this->data->mcu_date) . ".pdf";
            $this->staff = Employee::where('user_id', $this->data->staff_id)->first();

            $this->mcu_date = Carbon::parse($this->data['mcu_date'])->format('d M Y');
            $this->mcu_exp_date = Carbon::parse($this->data['mcu_exp_date'])->format('d M Y');
            $this->employee_birthdate = Carbon::parse($this->data['employee']['date_of_birth'])->format('d M Y');
            $this->employee_age = Carbon::parse($this->data['employee']['date_of_birth'])->age;

            $this->doctor_status_review = $this->data['doctor_status_review'];
            $this->amc_matrix_compliance = $this->data['amc_matrix_compliance'];
            $this->doctor_suggestion = $this->data['doctor_suggestion'];
            $this->doctor_spesialist_id = $this->data['doctor_spesialist_id'];
        }
    }

    public function setMcuId($id)
    {
        $this->mcu_id = $id;

        $this->data = MedicalHistory::with('employee')->where('id', $id)->first();

        if (!$this->data) {
            // return abort(404);
        } else {
            $this->mcu_staff_list =  MedicalHistory::with('employee')->where('employee_id', auth()->user()->employee->id)->get();
            $this->employee_age = Carbon::parse($this->data->employee->date_of_birth)->age;

            $this->file = "" . $this->data->employee_id . "-" . slugify($this->data->mcu_date) . ".pdf";
            $this->staff = Employee::where('user_id', $this->data->staff_id)->first();

            $this->mcu_date = Carbon::parse($this->data['mcu_date'])->format('d M Y');
            $this->mcu_exp_date = Carbon::parse($this->data['mcu_exp_date'])->format('d M Y');
            $this->employee_birthdate = Carbon::parse($this->data['employee']['date_of_birth'])->format('d M Y');
            $this->employee_age = Carbon::parse($this->data['employee']['date_of_birth'])->age;

            $this->doctor_status_review = $this->data['doctor_status_review'];
            $this->amc_matrix_compliance = $this->data['amc_matrix_compliance'];
            $this->doctor_suggestion = $this->data['doctor_suggestion'];
            $this->doctor_spesialist_id = $this->data['doctor_spesialist_id'];

            $this->render();
        }
    }

    public function pdf($id)
    {
        $mcu = MedicalHistory::find($id);
        $file = "" . storage_path('app/mcu_attachment/') . "" . $mcu->employee_id . "-" . slugify($mcu->mcu_date) . ".pdf";

        return response()->file($file);
    }

    public function render()
    {
        return view('mcu::livewire.patient.details')->extends('mcu::layouts.no-header');
    }
}
