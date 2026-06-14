<?php

namespace App\Http\Livewire\DocumentSystems\ActiveDocument;

use Livewire\Component;

class ActiveDocument extends Component
{
    public $document = [];

    public function render()
    {
        return view('livewire.document-systems.active-document.active-document')
            ->layout(\App\View\Components\Layouts\DocumentSystems::class);
    }
}
