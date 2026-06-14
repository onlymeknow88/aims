<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Document\Active;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;

class ActiveFieldLeadershipPage extends Component
{
    public function render()
    {
        return view('fieldleadership::livewire.listing.document.active.active-field-leadership-page')->layout('fieldleadership::layouts.app');
    }
}
