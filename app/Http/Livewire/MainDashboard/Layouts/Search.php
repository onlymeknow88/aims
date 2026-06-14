<?php

namespace App\Http\Livewire\MainDashboard\Layouts;

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
        return view('livewire.main-dashboard.layouts.search');
    }
}
