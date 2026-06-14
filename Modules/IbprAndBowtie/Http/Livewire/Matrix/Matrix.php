<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Matrix;

use Livewire\Component;

class Matrix extends Component
{
    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.matrix.matrix')->extends('layouts.no-header');
    }
}