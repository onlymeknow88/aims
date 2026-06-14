<?php

namespace Modules\Audit\Http\Livewire\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component
{
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


    public function doLogin()
    {
        $this->validate();

        \Auth::guard('audit')->attempt([
            'email'=>$this->email,
            'password'=>$this->password
        ],$this->remember);
        session()->flash('success',"Berhasil Login");
        return redirect()->route('audit::dashboard');
    }


    public function render(): Factory|View|Application
    {
        return view('audit::livewire.auth.login')->extends('layouts.no-header');
    }
}
