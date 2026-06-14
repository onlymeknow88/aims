<?php

namespace Modules\KO\Http\Livewire\RequestQR;

use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Detail extends Component
{
    use LivewireAlert;
    
    public $koProposal = [];

    public function mount($id): void
    {
        $this->koProposal = KoProposal::find($id);
    }

    public function verify()
    {
        $this->koProposal->update([
        	'status' => 'Review Coordinator'
        ]);

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::ko.index');
    }

    public function verifyCoordinator()
    {
        $this->koProposal->update([
        	'status' => 'Komisioning'
        ]);

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::ko.index');
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
        return view('ko::livewire.request-qr.detail')->extends('ko::layouts.no-header');
    }
}
