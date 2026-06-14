<?php

namespace App\Http\Livewire\Pica\Listing\FieldLeadership;

use App\Models\FieldLeadership;
use Livewire\Component;

class DetailFieldLeadershipPage extends Component
{
    public $field;

    public function mount($id)
    {
        $this->field = FieldLeadership::find($id);
    }

    public function render()
    {
        return view('livewire.pica.listing.field-leadership.detail-field-leadership-page')->extends('livewire.pica.layouts.no-header');
    }
}
