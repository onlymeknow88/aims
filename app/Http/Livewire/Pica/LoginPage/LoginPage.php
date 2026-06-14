<?php

namespace App\Http\Livewire\Pica\LoginPage;

use Livewire\Component;

class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.pica.login-page.login-page')->extends('livewire.pica.layouts.no-header');
    }
}
