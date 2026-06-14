<?php

namespace Modules\FieldLeadership\Http\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LoginPage extends Component
{
    use LivewireAlert;

    public $email;
    public $password;
    public $remember;

    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];

    public function loginStore()
    {
        $validatedData = $this->validate();

        if (Auth::guard('field-leadership')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->flash('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('field-leadership::dashboard');
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Failed',
            'icon' => 'danger',
            'text' => 'Credential does not match our record!',
        ]);
    }

    public function render()
    {
        return view('fieldleadership::livewire.login.login-page')->extends('fieldleadership::layouts.no-header');
    }
}
