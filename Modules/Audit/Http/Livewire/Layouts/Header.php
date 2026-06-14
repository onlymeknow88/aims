<?php

namespace Modules\Audit\Http\Livewire\Layouts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Redirector;

class Header extends Component
{
    public function logout(): \Illuminate\Http\RedirectResponse|Redirector
    {
        \Auth::guard('audit')->logout();
        return redirect()->route('audit::auth.login');
    }
    public function render(): Factory|View|Application
    {
        return view('audit::livewire.layouts.header');
    }
}
