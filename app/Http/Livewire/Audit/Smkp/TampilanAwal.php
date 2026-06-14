<?php

namespace App\Http\Livewire\Audit\Smkp;

use Livewire\Component;

class TampilanAwal extends Component
{
    public $konfirmasi = 'confirmance';
    public function render()
    {
        return view('livewire.audit.smkp.tampilan-awal');
    }
}
