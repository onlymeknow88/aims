<?php

namespace Modules\KO\Http\Livewire\ProposalVerification\CoordinatorVerification;

use App\Enums\KO\KoStatus;
use App\Mail\KO\ProposalUpdated;
use App\Mail\KO\ProposalVerifiedByCoordinator;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mail;
use Modules\KO\Entities\KoProposal;
use PDF;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CoordinatorVerificationDetail extends Component
{
    use LivewireAlert;
    
    public $koProposal = [];
    public $proposal_reject_note = "";

    public function mount($id): void
    {
        $this->koProposal = KoProposal::find($id);
    }

    public function verify()
    {
        $this->koProposal->update([
        	'status' => KoStatus::Commissioning()->value
        ]);

        Mail::to($this->koProposal->pjo->email)->send(new ProposalUpdated($this->koProposal));

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::proposal-verification.coordinator-verification.index');
    }

    public function reject()
    {
        $this->koProposal->update([
            'status' => KoStatus::Returned()->value,
            'proposal_reject_note' => $this->proposal_reject_note
        ]);

        Mail::to($this->koProposal->pjo->email)->send(new ProposalUpdated($this->koProposal));

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::proposal-verification.admin-verification.index');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
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
        return view('ko::livewire.proposal-verification.coordinator-verification.coordinator-verification-detail')->extends('ko::layouts.no-header');
    }
}
