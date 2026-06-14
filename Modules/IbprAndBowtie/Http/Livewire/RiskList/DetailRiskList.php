<?php

namespace Modules\IbprAndBowtie\Http\Livewire\RiskList;

use Livewire\Component;

class DetailRiskList extends Component {
    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.risk-list.detail')->extends('layouts.no-header');
    }
}