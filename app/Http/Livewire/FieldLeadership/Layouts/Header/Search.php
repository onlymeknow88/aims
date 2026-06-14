<?php

namespace App\Http\Livewire\FieldLeadership\Layouts\Header;

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
        return view('livewire.field-leadership.layouts.header.search');
    }
}
