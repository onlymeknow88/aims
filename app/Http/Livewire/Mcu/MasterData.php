<?php

namespace App\Http\Livewire\Mcu;

use App\Models\Mcu\Doctor;
use App\Models\Mcu\Provider;
use Livewire\Component;

class MasterData extends Component
{
    public $staff_id = 1;
    public $employee_id = null;

    // Provider
    public $status, $name;
    public $doctor_name = 'dr. ', $specialist;

    public function updateDoctor($id)
    {
        try {
            $updated = Doctor::where('id', $id)->update([
                'status' => 'active',
            ]);
            if ($updated) {
                Doctor::where('id', '!=', $id)->update([
                    'status' => 'inactive',
                ]);
            }
            session()->flash('msg', __('Data Formula Blood Pressure Terupdate'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function saveDoctor()
    {
        $this->validate([
            'doctor_name' => 'required',
            'specialist' => 'required',
        ]);
        try {
            $Doctor = Doctor::create([
                'name' => $this->doctor_name,
                'specialist' => $this->specialist,
            ]);

            session()->flash('msg', __('Data Dokter Spesialis Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::master-data');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }

    public function updateProvider($id)
    {
        try {
            $updated = Provider::where('id', $id)->update([
                'status' => 'active',
            ]);

            if ($updated) {
                Provider::where('id', '!=', $id)->update([
                    'status' => 'inactive',
                ]);
            }
            session()->flash('msg', __('Data Formula Dislipidemia Terupdate'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');

        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function saveProvider()
    {
        $this->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        try {
            $Provider = Provider::create([
                'name' => $this->name,
                'status' => $this->status,
            ]);
            session()->flash('msg', __('Data Provider Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::master-data');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function render()
    {
        $Provider = Provider::orderBy('name', 'ASC')->get();
        $Doctor = Doctor::orderBy('name', 'ASC')->get();

        return view('livewire.mcu.master-data', ['Provider' => $Provider, 'Doctor' => $Doctor]);
    }
}
