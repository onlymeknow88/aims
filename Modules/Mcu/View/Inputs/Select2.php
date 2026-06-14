<?php

namespace Modules\KPP\View\Inputs;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $id;
    public $placeholder;
    public $error;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id,
        $placeholder = 'Select Option',
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
        return view('mcu::components.inputs.select2');
    }
}
