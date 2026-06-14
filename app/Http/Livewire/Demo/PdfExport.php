<?php

namespace App\Http\Livewire\Demo;


use Livewire\Component;
use PDF;

class PdfExport extends Component
{
    public function render()
    {
        //return view('livewire.demo.pdf.pdf');
        return view('livewire.demo.pdf.invoice');
    }

    public function export()
    {
        $pdfContent = PDF::loadView('livewire.demo.pdf.invoice')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "invoice.pdf"
        );
    }
}
