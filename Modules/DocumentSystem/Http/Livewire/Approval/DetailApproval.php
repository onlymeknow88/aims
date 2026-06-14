<?php

namespace Modules\DocumentSystem\Http\Livewire\Approval;

use Livewire\Component;

class DetailApproval extends Component
{
    public function render()
    {
        return view('documentsystem::livewire.approval.detail-approval')->extends('documentsystem::layouts.no-header');
    }
}
