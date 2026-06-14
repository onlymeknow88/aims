<?php

namespace App\Http\Livewire\Inspeksi;

use Livewire\Component;

class InspeksiAlat extends Component
{
    public $itemSelected = [];
    public $countSelected = 0;
    public $searcInspectionType;
    
    public function render()
    {
        return view('livewire.inspeksi.inspeksi-alat');
    }
}
