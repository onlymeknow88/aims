<?php

namespace Modules\Mcu\Http\Livewire\Patient;

use Auth;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Mcu\Entities\MedicalHistory;

class Lists extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $limit;

    public $countData = 0;
    public $columns = ['Date', 'Name', 'Umur', 'Company', 'Department', 'Status Review', 'Status', 'Aksi'];
    public $selectedColumns = [];
    public $latestUpdate = '       ';

    public $searchTerm = "", $searchTermName = "";
    public $sortTerm = "", $sortTermName = "";

    public function mount()
    {
        $this->selectedColumns = $this->columns;
    }
    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }
    public function render()
    {
        $dataTables = MedicalHistory::with('employee');
        $dataTables->where('doctor_status_review', '!=', 'draft');
        $dataTables->orWhere('doctor_status_review', 'In Review');

        if ($this->searchTerm) {
            $dataTables->whereHas('employee', function ($q) {
                $q->where('name', 'like', "%" . $this->searchTerm . "%");
            });
        }

        // if (Auth::user()->hasPermissionTo('MCU - View MCU Patient')) {
            $dataTables->orderBy('created_at', 'ASC');
            return view('mcu::livewire.patient.lists', ['dataTables' => $dataTables->paginate($this->limit)]
            )->layout('mcu::layouts.app');
        // } else {
        //     return abort(404);
        // }
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
        $this->SetSelected();

    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
        $this->SetSelected();
    }

    public function SetSelected()
    {
        if ($this->countSelected == 1) {
            foreach ($this->itemSelected as $val) {
                $id = $val;
            }
            $this->idSelected = $id;
            $selectedData = MedicalHistory::find($id);
            $this->doctorStatusReview = $selectedData->doctor_status_review;
            $this->carbonNow = Carbon::now()->diffInMinutes(Carbon::parse($selectedData->updated_at));
        }

    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }
}
