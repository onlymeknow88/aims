<?php

namespace Modules\CSMS\View\Layouts;

use Illuminate\Console\View\Components\Component;

class NoHeader extends Component
{
    public function render()
    {
        return view('csms::layouts.no-header');
    }
}
