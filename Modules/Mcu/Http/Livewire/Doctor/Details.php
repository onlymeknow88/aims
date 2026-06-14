<?php

namespace Modules\Mcu\Http\Livewire\Doctor;

use App\Models\Employee;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\Mcu\Entities\Doctor;
use Modules\Mcu\Entities\MedicalHistory;

class Details extends Component
{
    use LivewireAlert;

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
        $user_id = auth()->user()->id;

        $this->data = MedicalHistory::with('employee', 'provider')->where('id', $id)->first();

        // $file = "" . $this->data->employee_id . "-" . slugify($this->data->mcu_date) . ".pdf";

        $this->file = "" . $this->data->employee_id . "-" . slugify($this->data->mcu_date) . ".pdf";

        if (Storage::disk('public')->exists('mcu/attachment/' . $this->file . '')) {
            $this->file_status = true;
        } else {
            $this->file_status = false;
        }

        $this->mcu_date = Carbon::parse($this->data['mcu_date'])->format('d M Y');
        $this->mcu_exp_date = Carbon::parse($this->data['mcu_exp_date'])->format('d M Y');
        $this->employee_birthdate = Carbon::parse($this->data['employee']['date_of_birth'])->format('d M Y');
        $this->employee_age = Carbon::parse($this->data['employee']['date_of_birth'])->age;

        $this->staff = Employee::where('user_id', $this->data->staff_id)->first();

        $this->mcu_staff_list = MedicalHistory::with('employee', 'provider')->where('staff_id', $this->data->staff_id)->get();

        $this->mcu_id = $id;

        $this->doctor_status_review = $this->data['doctor_status_review'];
        $this->amc_matrix_compliance = $this->data['amc_matrix_compliance'];
        $this->doctor_suggestion = $this->data['doctor_suggestion'];
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
                $array_count = array('Fit', 'Unfit');
            } elseif ($this->doctor_status_review == 'Fit With Recomendation') {
                $code = 'FWR';
                $array_count = array('Fit With Recomendation');
            } elseif ($this->doctor_status_review == 'Curently Unfit') {
                $code = 'CUF';
                $array_count = array('Curently Unfit');
            } elseif ($this->doctor_status_review == 'Unfit') {
                $code = 'UNF';
                $array_count = array('Fit', 'Unfit');
            } else {
                $code = '-';
            }

            $doctor_certificate_number = "" . $code . "/" . Carbon::now()->format('d/m/y') . "/00" . $count_mcu . "";

            $count = MedicalHistory::whereIn('doctor_status_review', $array_count)
                ->where(DB::raw('YEAR(mcu_date)'), '=', Carbon::now()->format('Y'))
                ->count();

            MedicalHistory::where('id', $this->mcu_id)->update([
                'doctor_id' => auth()->user()->employee->id,
                'doctor_status_review' => $this->doctor_status_review,
                'doctor_suggestion' => $this->doctor_suggestion,
                'doctor_spesialist_id' => $this->doctor_spesialist_id,
                'mcu_review_date' => Carbon::now(),
                'doctor_remark' => $count + 1,
                // 'mcu_exp_date' => Carbon::now()->addDays(30),
                'doctor_certificate_number' => $doctor_certificate_number,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data berhasil tersimpan.',
            ]);

            redirect()->route('mcu::doctor-list');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('MCU - View Detail MCU Doctor')) {
            $doctor = Doctor::orderBy('name', 'ASC')->get();

            return view('mcu::livewire.doctor.details', ['data' => $this->data, 'staff' => $this->staff, 'mcu_staff_list' => $this->mcu_staff_list, 'doctor' => $doctor])->extends('mcu::layouts.no-header');
        } else {
            return abort(404);
        }
    }
}
