<?php

namespace Modules\FieldLeadership\View\Layouts;

use Illuminate\Console\View\Components\Component;

class NoHeader extends Component
{
    public function render()
    {
        return view('fieldleadership::layouts.no-header');
    }
}
