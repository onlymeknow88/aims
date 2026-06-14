<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Audit extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function logout()
    {
        \Auth::logout();
        return redirect(request()->url());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.audit');
    }
}
