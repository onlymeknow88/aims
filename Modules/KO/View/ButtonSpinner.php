<?php

namespace Modules\KO\View;

use Illuminate\View\Component;

class ButtonSpinner extends Component
{
    public $target;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($target, $text)
    {
        $this->target = $target;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-spinner');
    }
}
