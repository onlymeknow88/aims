<?php

namespace Modules\Kplh\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;

    public string $email;
    public string $password;
    public bool $remember = true;
    public bool $show_password = false;

    protected $rules = [
        'email' => 'email|required',
        'password' => 'required',
        'remember' => 'nullable'
    ];

    public function loginStore()
    {
        $this->validate();

        if (Auth::guard('kplh')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {

            $this->alert('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('kplh::dashboard');
        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'danger',
                'text' => 'Credential does not match our record!',
            ]);
        }
    }

    public function render()
    {
        return view('kplh::livewire.auth.login')->extends('kplh::layouts.no-header');
    }
}
