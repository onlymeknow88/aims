<?php

namespace Modules\Sap\Http\Livewire\Layouts;

use Livewire\Component;

class Search extends Component
{
    public $search;

    public function search()
    {
        $this->emit('search', $this->search);
    }

    public function render()
    {
        return view('sap::layouts.header.search');
    }
}
