<?php

namespace Modules\DocumentSystem\View\Layouts;

use Illuminate\Console\View\Components\Component;

class App extends Component
{
    public function render()
    {
        return view('documentsystem::layouts.app');
    }
}
