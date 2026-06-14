<?php

namespace Modules\KO\Http\Livewire\Commissioning;

use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CommissionedDetail extends Component
{
    public $koProposal = [];

    public function mount($id): void
    {
        $this->koProposal = KoProposal::find($id);
    }

    public function export()
    {
    	// $pdf = PDF::loadview('ko::livewire.commissioning.export', ['data' => $this->koProposal]);
    	// return $pdf->download('laporan-pegawai-pdf');

        $pdfContent = PDF::loadView('ko::livewire.commissioning.export', ['data' => $this->koProposal])->setWarnings(false)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "commissioning.pdf"
        );
    }

    public function render()
    {
        return view('ko::livewire.commissioning.commissioned-detail')->extends('ko::layouts.no-header');
    }
}
