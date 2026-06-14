<?php

namespace Modules\DocumentSystem\Http\Livewire\Partials;

use Livewire\Component;

class Search extends Component
{
    public $search;

    public function updatedSearch()
    {
        $this->emit('searchUpdated', $this->search);
    }

    public function render()
    {
        return view('documentsystem::layouts.partials.search');
    }
}
