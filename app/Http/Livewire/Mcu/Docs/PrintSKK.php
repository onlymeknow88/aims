<?php

namespace App\Http\Livewire\Mcu\Docs;

use App\Models\Employee;
use App\Models\Mcu\MedicalHistory;
use Livewire\Component;

class PrintSKK extends Component
{

    public $staff_id = 1;

    public $data;
    public $staff;
    public $mcu_staff_list;

    public function mount($id)
    {
        $this->data = MedicalHistory::with('employee')->where('id', $id)->first();
        // $this->staff = Employee::find($this->staff_id);
        // $this->mcu_staff_list = MedicalHistory::with('employee')->where('staff_id', $this->staff_id)->get();

    }
    public function render()
    {
        return view('livewire.mcu.docs.print-s-k-k', ['data' => $this->data])->extends('layouts.no-header');

    }
}
