<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

class RencanaAudit extends Component
{
    public function render()
    {
        return view('livewire.audit.rencana-audit')->extends('layouts.no-header');
    }
}
