<?php

namespace Modules\Mcu\Http\Livewire\MedicalStaff;

use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Modules\Mcu\Entities\MedicalHistory;

class Details extends Component
{
    public $data;
    public $file, $file_status;
    public $staff;
    public $mcu_staff_list;
    public $mcu_details;

    public function mount($id)
    {
        $user_id = auth()->user()->id;

        $this->data = MedicalHistory::with('employee')->where('id', $id)->first();
        $this->employee_age = Carbon::parse($this->data['employee']['date_of_birth'])->age;

        $this->staff = Employee::where('user_id', $user_id)->first();
        $this->mcu_staff_list = MedicalHistory::with('employee')->where('staff_id', $user_id)->get();


        $this->file = "" . $this->data->employee_id . "-" . slugify($this->data->mcu_date) . ".pdf";

        if (Storage::disk('public')->exists('mcu/attachment/' . $this->file . '')) {
            $this->file_status = true;
        } else {
            $this->file_status = false;
        }
    }

    public function pdf($id)
    {
        $mcu = MedicalHistory::find($id);
        $file = "" . storage_path('app/public/mcu/attachment/') . "" . $mcu->employee_id . "-" . slugify($mcu->mcu_date) . ".pdf";

        return response()->file($file);
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('MCU - View Detail MCU Medical Staff')) {
            return view('mcu::livewire.medical-staff.details', ['data' => $this->data, 'staff' => $this->staff, 'mcu_staff_list' => $this->mcu_staff_list])->extends('mcu::layouts.no-header');
        } else {
            return abort(404);
        }
    }
}
