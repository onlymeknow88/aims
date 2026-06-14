<?php

namespace Modules\Kplh\View\Components\Inputs;

use Illuminate\View\Component;

class Datepicker30d extends Component
{
    public $id;
    public $error;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id,
        $placeholder = '-',
        $error = null,
    )
    {
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('kplh::components.inputs.datepicker-30d');
    }
}
