<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

class FormulirKesesuaian extends Component
{
    public function render()
    {
        return view('livewire.audit.formulir-kesesuaian')->extends('layouts.no-header');
    }
}
