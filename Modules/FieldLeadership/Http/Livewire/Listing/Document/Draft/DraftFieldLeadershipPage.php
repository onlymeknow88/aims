<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Document\Draft;

use Modules\FieldLeadership\Entities\FieldLeadership;
use Livewire\Component;

class DraftFieldLeadershipPage extends Component
{
    public function render()
    {
        return view('fieldleadership::livewire.listing.document.draft.draft-field-leadership-page')->layout('fieldleadership::layouts.app');
    }
}
