<?php

namespace Modules\IbprAndBowtie\View\Layouts;

use Illuminate\Console\View\Components\Component;

class App extends Component
{
    public function render()
    {
        return view('ibprandbowtie::layouts.app');
    }
}
