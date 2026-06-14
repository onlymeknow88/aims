<?php

namespace Modules\KO\Http\Livewire\IssueReport;

use App\Enums\KO\IssueReportStatus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KO\Entities\KoIssueReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Returned extends Component
{
    use WithFileUploads, LivewireAlert;

    public $issueReports = [];

    public $itemSelected = [];
    public $countSelected = 0;

    // public $note;
    public $file = [];
    public $submitId;

    public function mount(): void
    {
        $this->issueReports = KoIssueReport::where('status', IssueReportStatus::Returned()->value)->get();
    }

    public function submitId($id)
    {
        $this->submitId = $id;
        $this->dispatchBrowserEvent('openModal');
    }

    public function submitToAdmin()
    {
        try {
            DB::beginTransaction();

            $issue = KoIssueReport::find($this->submitId);
            $issue->update([
                'status' => IssueReportStatus::AdminVerification()->value,
            ]);

            if ($this->file) {
                $issue->attachments()->delete();
            }

            foreach ($this->file as $key => $attachment) {
                $path = 'ko/commissioning-attachment/' . $issue->koProposal->id;
                $full_path = Storage::disk('public')->put($path, $attachment);
                $issue->attachments()->create([
                    'attachment' => $full_path,
                    'size' => $this->changeByte($attachment->getSize()),
                    'name' => $attachment->getClientOriginalName(),
                    'type' => $attachment->getClientOriginalExtension()
                ]);
            }

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::issue-report.returned');
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
        return view('ko::livewire.issue-report.returned')->layout('ko::layouts.app');
    }
}
