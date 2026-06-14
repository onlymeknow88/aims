<?php

namespace App\Http\Livewire\Mcu\Patient;

use Livewire\Component;

use App\Models\Employee;
use App\Models\Mcu\MedicalHistory;

class Details extends Component
{
    // public $mcu_id = '986e2145-ebe4-497a-b36d-ff33d89830be';
    public $staff_id = 1;

    public $data;
    public $staff;
    public $mcu_staff_list;

    public function mount($id)
    {
        $this->data = MedicalHistory::with('employee')->where('id', $id)->first();
        $this->staff = Employee::find($this->staff_id);
    }

    public function render()
    {
        return view('livewire.mcu.patient.details', ['data' => $this->data, 'staff' => $this->staff, 'mcu_staff_list' => $this->mcu_staff_list])->extends('layouts.no-header');
    }
}
