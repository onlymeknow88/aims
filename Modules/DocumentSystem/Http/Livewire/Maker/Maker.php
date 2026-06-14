<?php

namespace Modules\DocumentSystem\Http\Livewire\Maker;

use App\Models\Department;
use Livewire\Component;

class Maker extends Component
{
    public function render()
    {

        return view('documentsystem::livewire.maker.maker')->layout('documentsystem::layouts.app');
    }
}
