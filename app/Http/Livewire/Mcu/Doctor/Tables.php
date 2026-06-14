<?php

namespace App\Http\Livewire\Mcu\Doctor;

use App\Models\Mcu\MedicalHistory;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Tables extends Component
{
    use WithPagination;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $searchTerm = "";
    public $columns = ['Date', 'Name', 'Tanggal Lahir', 'Company', 'Department', 'Status Review', 'Status', 'Aksi'];
    public $selectedColumns = [];
    public $latestUpdate = '       ';

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
        // $dataTables = MedicalHistory::with('employee')->get();
        $dataTables = MedicalHistory::with('employee');
        $dataTables->where('doctor_status_review','!=', 'draft');
        $dataTables->orWhereNull('doctor_status_review');
        // $dataTables->whereNull('updated_at');
        $dataTables->where('updated_at', '<=', Carbon::tomorrow());

        if (!empty($this->searchTerm)) {
            $dataTables->whereHas('employee', function ($q) {
                $q->where('name', 'like', "%" . $this->searchTerm . "%");
            });
            $dataTables->orWhere('amc_matrix_compliance', 'like', "%" . $this->searchTerm . "%");
            $dataTables->orWhere('doctor_status_review', 'like', "%" . $this->searchTerm . "%");
        }

        $dataTables->orderBy('created_at', 'ASC');
        return view('livewire.mcu.doctor.tables', ['dataTables' => $dataTables->paginate(10)]
        );
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
}
