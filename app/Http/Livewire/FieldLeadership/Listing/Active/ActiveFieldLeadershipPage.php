<?php

namespace App\Http\Livewire\FieldLeadership\Listing\Active;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;

class ActiveFieldLeadershipPage extends Component
{
    public function render()
    {
        return view('livewire.field-leadership.listing.active.active-field-leadership-page')->layout('livewire.field-leadership.layouts.app');
    }
}
