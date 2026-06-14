<?php

namespace App\Http\Livewire\Mcu\Doctor;

use App\Models\Employee;
use App\Models\Mcu\Doctor;
use App\Models\Mcu\MedicalHistory;
use Carbon\Carbon;
use Livewire\Component;

class Details extends Component
{

    public $staff_id = 1;

    public $data;
    public $staff;
    public $mcu_id;
    public $mcu_staff_list;
    public $amc_matrix_compliance;
    public $doctor_status_review;
    public $doctor_spesialist_id;
    public $doctor_suggestion;
    public $doctor_certificate_number;
    public $doctor_expiration;
    public $doctor_remark;

    public function mount($id)
    {
        $this->mcu_id = $id;
        $this->data = MedicalHistory::with('employee')->where('id', $id)->first();
        $this->staff = Employee::find($this->staff_id);
        $this->mcu_staff_list = MedicalHistory::with('employee')->where('staff_id', $this->staff_id)->get();
        $this->doctor_status_review = $this->data['amc_matrix_compliance'];
        $this->doctor_spesialist_id = $this->data['doctor_spesialist_id'];
    }
    public function hydrate()
    {
        $this->emit('select2');
    }
    public function save()
    {
        $this->validate([
            'doctor_status_review' => 'required',
        ]);

        try {
            $mcu = MedicalHistory::whereDate('created_at', Carbon::today())->get();
            $count_mcu = $mcu->count() + 1;

            if ($this->doctor_status_review == 'Fit') {
                $code = 'FIT';
            } elseif ($this->doctor_status_review == 'Fit With Recomendation') {
                $code = 'FWR';
            } elseif ($this->doctor_status_review == 'Curently Unfit') {
                $code = 'CUF';
            } elseif ($this->doctor_status_review == 'Unfit') {
                $code = 'UNF';
            } else {
                $code = '-';
            }

            $doctor_certificate_number = "" . $code . "/" . Carbon::now()->format('d/m/y') . "/00" . $count_mcu . "";

            MedicalHistory::where('id', $this->mcu_id)->update([
                'doctor_status_review' => $this->doctor_status_review,
                'doctor_suggestion' => $this->doctor_suggestion,
                'doctor_spesialist_id' => $this->doctor_spesialist_id,
                'mcu_review_date' => Carbon::now(),
                'mcu_exp_date' => Carbon::now()->addDays(30),
                'doctor_certificate_number' => $doctor_certificate_number,
            ]);

            // $this->reset();

            session()->flash('msg', __('Data Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::doctor-list');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function render()
    {
        $doctor = Doctor::orderBy('name', 'ASC')->get();

        return view('livewire.mcu.doctor.details', ['data' => $this->data, 'staff' => $this->staff, 'mcu_staff_list' => $this->mcu_staff_list, 'doctor' => $doctor])->extends('layouts.no-header');
    }
}
