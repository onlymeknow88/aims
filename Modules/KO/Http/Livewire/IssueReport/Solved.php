<?php

namespace Modules\KO\Http\Livewire\IssueReport;

use App\Enums\KO\IssueReportStatus;
use Livewire\Component;
use Modules\KO\Entities\KoIssueReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Solved extends Component
{
    public $issueReports = [];

    public $itemSelected = [];
    public $countSelected = 0;

    // public $note;

    public function mount(): void
    {
        $this->issueReports = KoIssueReport::where('status', IssueReportStatus::Solved()->value)->get();
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
        return view('ko::livewire.issue-report.solved')->layout('ko::layouts.app');
    }
}
