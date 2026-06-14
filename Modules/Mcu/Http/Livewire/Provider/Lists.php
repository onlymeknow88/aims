<?php

namespace Modules\Mcu\Http\Livewire\Provider;

use Auth;
use Livewire\Component;
use Modules\Mcu\Entities\Doctor;
use Modules\Mcu\Entities\Provider;

class Lists extends Component
{
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
            redirect()->route('mcu::manage-provider');
        } catch (\Throwable $th) {
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
            redirect()->route('mcu::manage-provider');
        } catch (\Throwable $th) {
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
            redirect()->route('mcu::manage-provider');

        } catch (\Throwable $th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function saveProvider()
    {
        $this->validate([
            'name' => 'required',
            // 'status' => 'required',
        ]);
        try {
            $Provider = Provider::create([
                'name' => $this->name,
                'status' => $this->status ? $this->status : 'active',
            ]);
            session()->flash('msg', __('Data Provider Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::manage-provider');
        } catch (\Throwable $th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function render()
    {
        if (Auth::user()->hasPermissionTo('MCU - Manage Provider MCU')) {
            $Provider = Provider::orderBy('name', 'ASC')->get();
            $Doctor = Doctor::orderBy('name', 'ASC')->get();

            return view('mcu::livewire.provider.lists', ['Provider' => $Provider, 'Doctor' => $Doctor])->layout('mcu::layouts.app');
        } else {
            return abort(404);
        }
    }
}
