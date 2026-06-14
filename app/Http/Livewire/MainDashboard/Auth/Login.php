<?php

namespace App\Http\Livewire\MainDashboard\Auth;

use Livewire\Component;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\DocumentSystem\View\Layouts\Base;

class Login extends Component
{
    use AuthenticatesUsers, LivewireAlert;

    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function getRules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'remember' => 'nullable'
        ];
    }


    public function login()
    {
        //validate
        $validation = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
        $this->validate($validation);

        $auth = Auth::guard('dashboard')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember);

        if ($auth) {
            return redirect()->intended('/');
        }

        return session()->flash('error', 'The provided credentials do not match our records.');
    }


    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('dashboard');
    }

    public function render()
    {
        return view('livewire.main-dashboard.auth.login')
            ->layout('layouts.base');
    }
}
