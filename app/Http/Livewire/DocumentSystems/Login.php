<?php

namespace App\Http\Livewire\DocumentSystems;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Livewire\Component;

class Login extends Component
{
    use AuthenticatesUsers;

    public $email;
    public $password;
    public $ingat;

    protected $rules = [
        'email' => 'required',
        'password' => 'required',
        'ingat' => 'required',
    ];

    public function loginStore()
    {
        // $this->validate([
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        if (\Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->ingat)) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon'=>'success',
                'text'  => 'Data berhasil di simpan'
            ]);
            return redirect()->route('document-systems::dashboard');
        }
    }

    public function render()
    {
        return view('livewire.document-systems.login')->extends('layouts.no-header');
    }
}
