<?php

namespace Modules\CSMS\View\Layouts;

use Illuminate\Console\View\Components\Component;

class App extends Component
{
    public function render()
    {
        return view('csms::layouts.app');
    }
}
