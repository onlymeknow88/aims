<?php

namespace Modules\KO\View\Layouts;

use Illuminate\View\Component;

class Noheader extends Component
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('ko::layouts.no-header');
    }
}
