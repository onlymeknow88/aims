<?php

namespace Modules\CSMS\Http\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LoginPage extends Component
{
    use LivewireAlert;

    public string $email;
    public string $password;
    public bool $remember = true;
    public bool $show_password = false;

    protected $rules = [
        'email'=>'email|required',
        'password'=>'required',
        'remember'=>'nullable'
    ];

    public function toggleShowPassword(bool $value):void
    {
        $this->show_password = $value;
    }

    public function loginStore()
    {
        $this->validate();

        if (Auth::guard('csms')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->flash('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('csms::dashboard');
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Failed',
            'icon' => 'danger',
            'text' => 'Credential does not match our record!',
        ]);
    }

    public function render()
    {
        return view('csms::livewire.login.login-page')->extends('csms::layouts.no-header');
    }
}
