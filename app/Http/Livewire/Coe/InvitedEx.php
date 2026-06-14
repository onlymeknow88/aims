<?php

namespace App\Http\Livewire\Coe;

use Livewire\Component;

class InvitedEx extends Component
{

    public $ids;

    protected $queryString = ['ids'];

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.coe.invited-ex')->extends('layouts.no-header');
    }
}
