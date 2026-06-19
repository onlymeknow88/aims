<?php

namespace Modules\KO\Http\Livewire\RequestQR;

use App\Enums\KO\IssueReportStatus;
use App\Enums\KO\KoStatus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KO\Entities\KoIssueReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\KO\Entities\KoProposal;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RequestQR extends Component
{
    use WithFileUploads, LivewireAlert;

    public $koProposals = [];

    public $itemSelected = [];
    public $countSelected = 0;

    public $returned_message;
    public $file = [];
    public $submitId;

    public $temporary_validity_period;

    public function mount(): void
    {
        $this->koProposals = KoProposal::whereIn('status', [KoStatus::Issue()->value, KoStatus::CoordinatorCommissioningVerification()->value, KoStatus::CommissionerCommissioningVerification()->value, KoStatus::CommissioningReturned()->value])->get();
    }

    public function submitId($id)
    {
        $this->submitId = $id;
        $this->dispatchBrowserEvent('openModal');
    }

    public function submitToCoordinator()
    {
        try {
            DB::beginTransaction();

            $proposal = KoProposal::find($this->submitId);
            $proposal->update([
                'temporary_validity_period' => Carbon::parse($this->temporary_validity_period)->format('Y-m-d'),
                'temporary_qr_status' => 'Coordinator Verification'
            ]);

            if ($this->file) {
                $proposal->koQrRequestFiles()->delete();
            }

            foreach ($this->file as $key => $attachment) {
                $filename = $attachment->getClientOriginalName();
                $filePathTemp = $attachment->getRealPath();
                $directPath = 'ko/qr-request-attachment/' . $proposal->id;

                $blobResult = uploadToBlobStorage($filename, $filePathTemp, $directPath);

                $proposal->koQrRequestFiles()->create([
                    'attachment' => $blobResult['fileBlobPathName'] ?? ('ko/qr-request-attachment/' . $proposal->id . '/' . $filename),
                    'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                    'blob_response' => $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null,
                    'size' => $this->changeByte($attachment->getSize()),
                    'name' => $filename,
                    'type' => $attachment->getClientOriginalExtension()
                ]);
            }

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::request-qr.index');
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

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
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
        return view('ko::livewire.request-qr.request-qr')->layout('ko::layouts.app');
    }
}
