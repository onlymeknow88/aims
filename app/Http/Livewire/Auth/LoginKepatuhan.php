<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class LoginKepatuhan extends Component
{
    public $email;
    public $password;
    public $ingat;


    public function render()
    {
        return view('livewire.auth.login-kepatuhan')->extends('layouts.no-header');
    }

    public function loginStore(){
        $validatedData = $this->validate();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'=>'success',
            'text'  => 'Data berhasil di simpan'
        ]);
    }
}
