<?php

namespace App\Http\Livewire\Mcu\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $ingat;

    public function render()
    {
        return view('livewire.mcu.auth.login')->extends('layouts.no-header');
    }

    // protected $rules = [
    //     'email' => 'required',
    //     'password' => 'required',
    //     'ingat' => 'required',
    // ];

    public function loginStore()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $this->email)->first();

        if ($user) {
            Session::put('login_status', true);
            Session::put('login_id', $user->id);
            Session::put('login_email', $this->email);

            // Session::put([
            //     'login_status' => true,
            //     'login_id' => $user->id,
            //     'login_email' => $this->email,
            // ]);

            if ($this->email == 'staff1@gmail.com') {
                return redirect()->route('mcu::medical-staff-list');
            } elseif ($this->email == 'karyawan1@gmail.com') {
                return redirect()->route('mcu::mcu-patient');
            } elseif ($this->email == 'company1@gmail.com') {
                return redirect()->route('mcu::mcu-company');
            } elseif ($this->email == 'doctor1@gmail.com') {
                return redirect()->route('mcu::doctor');
            } else {
                Session::flush();
            }
        } else {
            $employee = Employee::where('id_number', $this->email)->first();
            if ($employee) {
                return redirect()->route('mcu::mcu-patient');
            } else {
                # code...
                Session::flush();
            }
            // dd('b');
        }

        // $this->dispatchBrowserEvent('swal', [
        //     'title' => 'Berhasil',
        //     'icon' => 'success',
        //     'text' => 'Anda berhasil login',
        // ]);

        // Session::set('login_email', $this->email);

        // if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->ingat)) {
        //     Session::put('login_email', $this->email);
        //     $this->dispatchBrowserEvent('swal', [
        //         'title' => 'Berhasil',
        //         'icon' => 'success',
        //         'text' => 'Data berhasil di simpan',
        //     ]);
        //     return redirect()->route('mcu::medical-staff');
        // }

    }
}
