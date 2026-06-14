<?php

namespace App\Http\Livewire\DocumentSystems\Review;

use Livewire\Component;

class Review extends Component
{
    public function render()
    {
        return view('livewire.document-systems.review.review')
            ->layout(\App\View\Components\Layouts\DocumentSystems::class);
    }
}
