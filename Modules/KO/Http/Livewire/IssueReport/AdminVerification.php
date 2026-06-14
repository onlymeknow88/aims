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

class AdminVerification extends Component
{
    use WithFileUploads, LivewireAlert;

    public $issueReports = [];

    public $itemSelected = [];
    public $countSelected = 0;

    public $returned_message;
    public $file = [];
    public $submitId;

    public function mount(): void
    {
        $this->issueReports = KoIssueReport::where('status', IssueReportStatus::AdminVerification()->value)->get();
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

            $issues = KoIssueReport::whereIn('id', $this->itemSelected);
            $issues->update([
                'status' => IssueReportStatus::CoordinatorVerification()->value,
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::issue-report.admin-verification');
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

    public function return()
    {
        try {
            DB::beginTransaction();

            $units = KoIssueReport::whereIn('id', $this->itemSelected)->update([
                'status' => IssueReportStatus::Returned()->value,
                'returned_message' => $this->returned_message
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::issue-report.coordinator-verification');
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
        return view('ko::livewire.issue-report.admin-verification')->layout('ko::layouts.app');
    }
}
