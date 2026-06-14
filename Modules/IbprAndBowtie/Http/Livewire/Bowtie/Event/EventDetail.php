<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EventDetail extends Component
{
    public $event;

    public function mount($id){
        $this->event = BowtieEvent::find($id);
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.event-detail')->extends('ibprandbowtie::layouts.no-header');
    }
}
