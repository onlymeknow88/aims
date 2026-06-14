<?php

namespace Modules\FieldLeadership\Http\Livewire\Layouts\Header;

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
        return view('fieldleadership::layouts.header.field-leadership-search');
    }
}
