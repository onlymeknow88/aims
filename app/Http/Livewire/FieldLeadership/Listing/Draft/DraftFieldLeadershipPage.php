<?php

namespace App\Http\Livewire\FieldLeadership\Listing\Draft;

use App\Models\FieldLeadership;
use Livewire\Component;

class DraftFieldLeadershipPage extends Component
{
    public function getDraftListings(): LengthAwarePaginator
    {
        return FieldLeadership::where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.field-leadership.listing.draft.draft-field-leadership-page')->layout('livewire.field-leadership.layouts.app');
    }
}
