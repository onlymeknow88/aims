<?php

namespace Modules\DocumentSystem\Http\Livewire\ActiveDocument;

use Livewire\Component;
use Modules\DocumentSystem\View\Layouts\Base;

class ActiveDocument extends Component
{
    public $document = [];

    public function render()
    {
        return view('documentsystem::livewire.active-document.active-document')
            ->layout(Base::class);
    }
}
