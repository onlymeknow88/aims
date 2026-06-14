<?php

namespace Modules\KO\Http\Livewire\CommissioningVerification\AdminVerification;

use App\Enums\KO\KoStatus;
use App\Mail\KO\ProposalUpdated;
use App\Mail\KO\ProposalVerifiedByAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mail;
use Modules\KO\Entities\KoProposal;
use PDF;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AdminVerificationDetail extends Component
{
    use LivewireAlert;
    
    public $koProposal = [];
    public $commissioning_reject_note = "";

    protected $rules = [
        'internal_komisioning_schedule' => 'required|max:191',
    ];

    public function mount($id): void
    {
        $this->koProposal = KoProposal::find($id);
    }

    public function verify()
    {
        $this->koProposal->update([
        	'status' => KoStatus::CoordinatorCommissioningVerification()->value,
        ]);

        Mail::to($this->koProposal->pjo->email)->send(new ProposalUpdated($this->koProposal));

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::commissioning-verification.admin.index');
    }

    public function reject()
    {
        $this->koProposal->update([
            'status' => KoStatus::CommissioningReturned()->value,
            'commissioning_reject_note' => $this->commissioning_reject_note
        ]);

        Mail::to($this->koProposal->pjo->email)->send(new ProposalUpdated($this->koProposal));

        $this->flash('success','Berhasil mengupdate data!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('ko::commissioning-verification.admin.index');
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
        return view('ko::livewire.commissioning-verification.admin.admin-verification-detail')->extends('ko::layouts.no-header');
    }
}
