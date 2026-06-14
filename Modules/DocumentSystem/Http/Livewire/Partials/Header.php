<?php

namespace Modules\DocumentSystem\Http\Livewire\Partials;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{

    use AuthenticatesUsers;

    public function logout()
    {
        Auth::guard('document-system')->logout();
        $this->redirectRoute('document-systems::auth.login');
    }

    public function render()
    {
        return view('documentsystem::layouts.partials.header');
    }
}
