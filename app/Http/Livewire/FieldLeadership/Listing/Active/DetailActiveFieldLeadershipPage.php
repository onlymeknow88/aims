<?php

namespace App\Http\Livewire\FieldLeadership\Listing\Active;

use App\Models\FieldLeadership;
use Livewire\Component;

class DetailActiveFieldLeadershipPage extends Component
{
    public $field;

    public function mount($id)
    {
        $this->field = FieldLeadership::find($id);
    }

    public function render()
    {
        return view('livewire.field-leadership.listing.active.detail-field-leadership-page')->extends('livewire.field-leadership.layouts.no-header');
    }
}
