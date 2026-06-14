<?php

namespace Modules\KO\Http\Livewire\RequestQR;

use App\Enums\KO\IssueReportStatus;
use App\Enums\KO\KoStatus;
use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\KO\ProposalCompleted;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CoordinatorVerification extends Component
{
    use LivewireAlert;
    
    public $koProposals = [];

    public $itemSelected = [];
    public $countSelected = 0;

    public $returned_message;

    public function mount(): void
    {
        $this->koProposals = KoProposal::where('temporary_qr_status', 'Coordinator Verification')->get();
    }

    public function approve()
    {
        try {
            DB::beginTransaction();

            $proposals = KoProposal::whereIn('id', $this->itemSelected);
            $proposals->update([
                'temporary_qr_status' => 'Approved'
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::request-qr.coordinator-verification');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function reject()
    {
        try {
            DB::beginTransaction();

            $proposals = KoProposal::whereIn('id', $this->itemSelected);
            $proposals->update([
                'temporary_qr_status' => 'Rejected',
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::request-qr.coordinator-verification');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function onSelectedItem($id)
    {
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('ko::livewire.request-qr.coordinator-verification')->layout('ko::layouts.app');
    }
}
