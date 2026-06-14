<?php

namespace Modules\Coe\Http\Livewire\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

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

    public function toggleShowPassword(bool $value): void
    {
        $this->show_password = $value;
    }

    public function loginStore()
    {
        $this->validate();

        if (Auth::guard('coe')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {

            $this->alert('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('coe::callendar');
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Failed',
            'icon' => 'danger',
            'text' => 'Credential does not match our record!',
        ]);
    }

    public function render()
    {
        return view('coe::livewire.auth.login')->extends('coe::layouts.no-header');
    }
}
