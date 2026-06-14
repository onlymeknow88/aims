<?php

namespace App\Http\Livewire\FieldLeadership\LoginPage;

use Livewire\Component;

class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.field-leadership.login-page.login-page')->extends('livewire.field-leadership.layouts.no-header');
    }
}
