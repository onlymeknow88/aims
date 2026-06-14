<?php

namespace App\Http\Livewire\Mcu\RekamMedis;

use Livewire\Component;

class DetailRekamMedis extends Component
{
    public function render()
    {
        return view('livewire.mcu.rekam-medis.detail-rekam-medis')->extends('layouts.no-header');
    }
}
