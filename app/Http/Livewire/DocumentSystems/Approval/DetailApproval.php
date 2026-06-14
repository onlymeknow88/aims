<?php

namespace App\Http\Livewire\DocumentSystems\Approval;

use Livewire\Component;

class DetailApproval extends Component
{
    public function render()
    {
        return view('livewire.document-systems.approval.detail-approval')->extends('layouts.no-header');
    }
}
