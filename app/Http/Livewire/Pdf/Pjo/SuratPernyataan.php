<?php

namespace App\Http\Livewire\Pdf\Pjo;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPernyataan extends Component
{
    public function render()
    {
        return view('livewire.pdf.pjo.surat-pernyataan');
        //return view('livewire.pdf.pjo.surat-pernyataan-print')->extends('livewire.pdf.layouts.blank');
    }

    public function export()
    {
        $pdfContent = Pdf::loadView('livewire.pdf.pjo.surat-pernyataan-print')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "surat-pernyataan.pdf"
        );
    }
}
