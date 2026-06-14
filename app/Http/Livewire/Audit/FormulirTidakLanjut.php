<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

class FormulirTidakLanjut extends Component
{
    public function render()
    {
        return view('livewire.audit.formulir-tidak-lanjut')->extends('layouts.no-header');
    }
}
