<?php

namespace Modules\Pica\View\Layouts;

use Illuminate\Console\View\Components\Component;

class App extends Component
{
    public function render()
    {
        return view('pica::layouts.app');
    }
}
