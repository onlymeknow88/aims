<?php

namespace App\Http\Livewire\Pdf\Pjo;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class PersyaratanAdministratif extends Component
{
    public function render()
    {
        return view('livewire.pdf.pjo.persyaratan-administratif');
        //return view('livewire.pdf.pjo.persyaratan-administratif-print')->extends('livewire.pdf.layouts.blank');
    }

    public function export()
    {
        $pdfContent = Pdf::loadView('livewire.pdf.pjo.persyaratan-administratif-print')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "persyaratan-administratif.pdf"
        );
    }
}
