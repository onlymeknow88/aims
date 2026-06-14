<?php

namespace Modules\Coe\View\Inputs;

use Illuminate\View\Component;

class TextEditor extends Component
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
        $placeholder = '--',
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
        return view('coe::components.inputs.text-editor');
    }
}
