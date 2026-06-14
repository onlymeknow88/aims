<?php

namespace Modules\CSMS\Http\Livewire\Layouts\Header;

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
        return view('csms::layouts.header.search');
    }
}
