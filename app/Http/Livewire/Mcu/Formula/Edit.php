<?php

namespace App\Http\Livewire\Mcu\Formula;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('livewire.mcu.formula.edit')->extends('layouts.no-header');
    }
}
