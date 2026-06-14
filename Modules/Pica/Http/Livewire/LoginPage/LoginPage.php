<?php

namespace Modules\Pica\Http\Livewire\LoginPage;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

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

        if (Auth::guard('pica')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->flash('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('pica::dashboard');
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Failed',
            'icon' => 'danger',
            'text' => 'Credential does not match our record!',
        ]);
    }

    public function render()
    {
        return view('pica::livewire.login-page.login-page')->extends('pica::layouts.no-header');
    }
}
