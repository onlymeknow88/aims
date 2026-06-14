<?php

namespace Modules\DocumentSystem\Http\Livewire\Review;

use Livewire\Component;
use Modules\DocumentSystem\View\Layouts\Base;

class Review extends Component
{
    public function render()
    {
        return view('documentsystem::livewire.review.review')
            ->layout(Base::class);
    }
}
