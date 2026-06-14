<?php

namespace Modules\KO\Http\Livewire\IssueReport;

use App\Enums\KO\IssueReportStatus;
use App\Enums\KO\KoStatus;
use App\Mail\KO\ProposalUpdated;
use Livewire\Component;
use Modules\KO\Entities\KoIssueReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\KO\ProposalCompleted;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CoordinatorVerification extends Component
{
    use LivewireAlert;
    
    public $issueReports = [];

    public $itemSelected = [];
    public $countSelected = 0;

    public $returned_message;

    public function mount(): void
    {
        $this->issueReports = KoIssueReport::where('status', IssueReportStatus::CoordinatorVerification()->value)->get();
    }

    public function markAsSolved()
    {
        try {
            DB::beginTransaction();

            $issues = KoIssueReport::whereIn('id', $this->itemSelected);

            $issues->update([
                'status' => IssueReportStatus::Solved()->value,
            ]);

            foreach ($issues->get() as $issue) {
                $unsolvedIssue = KoIssueReport::where('ko_proposal_id', $issue->koProposal->id)
                    ->whereNot('status', 'Solved')->first();

                if ($unsolvedIssue == null) {
                    $issue->koProposal->update([
                        'status' => KoStatus::CommissionerCommissioningVerification()->value
                    ]);

                    Mail::to($issue->koProposal->pjo->email)->send(new ProposalUpdated($issue->koProposal));
                }

            }

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
        return view('ko::livewire.issue-report.coordinator-verification')->layout('ko::layouts.app');
    }
}
