<?php

namespace App\Http\Livewire\Mcu\MedicalStaff;

use App\Exports\Mcu\MedicalHistoryExport;
use App\Imports\Mcu\MedicalHistoryImport;
use App\Models\Mcu\MedicalHistory;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
// use Livewire\WithSorting;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Tables extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $listeners = ['confirmDelete'];

    protected $rules = ['excelFile' => 'required|file|mimes:xlsx, xls'];
    protected $paginationTheme = 'bootstrap';
    public $carbonNow;
    public $limit;
    public $dataTable;
    public $latestUpdate;
    public $search = '';
    public $excelFile;
    public $selectedData;
    public $doctorStatusReview;
    public $selectedDataUpdated_at;
    public $itemSelected = [];
    public $countSelected = 0;
    public $countData = 0;
    public $info = false;
    public $orderColumn = "frammingham_risk_level";
    public $sortOrder = "asc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchTerm = "";
    public $columns = ['Date', 'Name', 'Tanggal Lahir', 'Company', 'Department', 'Kesehatan', 'Status'];
    public $columnSort = [];
    public $dateFilter = '';
    public $dateSort = '';
    public $statusFilter;
    public $statusSort;
    public $companyFilter;
    public $companySort;
    public $departmentFilter;
    public $departmentSort;

    public $selectedColumns = [];

    public $sortBy = [];
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
        ? $this->reverseSort()
        : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
        ? 'desc'
        : 'asc';
    }

    public function mount($status)
    {
        dd($status);
        $this->limit = 50;
        $this->selectedColumns = $this->columns;
        // $this->carbonNow = Carbon::now();

        $dateLatest = MedicalHistory::orderBy('updated_at', 'desc')->first();
        $dateLatestParse = Carbon::parse($dateLatest->updated_at)->format('d M Y - g:i A');
        $this->latestUpdate = 'Last update on ' . $dateLatestParse . '';
    }

    public function get_mcu()
    {
        // reset($this->itemSelected);
        $this->itemSelected = array_values($this->itemSelected);
        // dd(array_shift($itemSelected));
        $selectedData = MedicalHistory::find($this->itemSelected[0]);
        $this->doctorStatusReview = $selectedData->doctor_status_review;
        $this->idSelected = $selectedData->id;

        $this->carbonNow = Carbon::now()->diffInMinutes(Carbon::parse($selectedData->updated_at));
    }

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function sortOrder($columnName = "")
    {
        $caretOrder = "up";
        if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
            $caretOrder = "down";
        } else {
            $this->sortOrder = 'asc';
            $caretOrder = "up";
        }
        $this->sortLink = '<i class="sorticon fa-solid fa-caret-' . $caretOrder . '"></i>';
        $this->orderColumn = $columnName;
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function import()
    {
        $this->validate();
        Excel::import(new MedicalHistoryImport, $this->excelFile);

        session()->flash('msg', __('Data MCU berhasil disimpan'));
        session()->flash('alert', 'success');
        redirect()->route('mcu::medical-staff');
    }

    public function export()
    {
        // dd($this->itemSelected);
        $file_name = "MCU-export-" . Carbon::now()->format('d-m-y-h-i-s') . "";
        return Excel::download(new MedicalHistoryExport($this->itemSelected), '' . $file_name . '.xlsx');
    }

    public function del($id)
    {
        $user = MedicalHistory::find($id);
        $user->delete();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data MCU-' . $id . ' berhasil di hapus',
        ]);
    }

    public function filterSort()
    {

        // $this->dataTable = MedicalHistory::with('employee')
        //     ->orderByRaw('' . $dateSort . '');
        // $this->dataTable = 'ss';
        $this->resetPage();

    }
    public function resetFilterSort()
    {
        $this->dateFilter = '';
        $this->dateSort = '';
        $this->statusFilter = '';
        $this->statusSort = '';
        $this->companyFilter = '';
        $this->companySort = '';
        $this->departmentFilter = '';
        $this->departmentSort = '';

    }

    public function delete()
    {

        $ids = implode(",", $this->itemSelected);
        // $text = 'Anda yakin akan menghapus data ini ?';

        $this->alert('question', '', [
            'title' => 'Hapus Event',
            'text' => 'Anda yakin akan menghapus data ini ?',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ya, Hapus',
            'showCancelButton' => true,
            'onConfirmed' => 'confirmDelete',
            'onDismissed' => 'cancelDelete',
            'cancelButtonText' => 'Tidak, Batalkan',
            'position' => 'center',
            'toast' => false,
            'timer' => null,
            'preConfirm' => "() => {return '{$ids}'}",
        ]);
    }

    public function confirmDelete($data)
    {
        // dd($data['value']);
        // dd($this->itemSelected);
        // $ids = explode(",", $this->itemSelected);
        // dd($ids);
        foreach ($this->itemSelected as $s) {
            $mcu = MedicalHistory::find($s);
            // dd($mcu);

            if ($mcu->doctor_status_review == 'draft') {
                $mcu->delete();
            }
        }

        session()->flash('msg', __('Data MCU berhasil dihapus'));
        session()->flash('alert', 'success');
        redirect()->route('mcu::medical-staff');

        // $this->flash('success', 'Data MCU berhasil dihapus.', [], route('mcu::medical-staff'));
    }

    public function cancelDelete()
    {
        $this->reset(['delete_id']);
    }

    public function render()
    {
        // if ($this->dataTable) {
        //     // dd($this->dataTable);
        // $dateSort = (empty($this->dateSort)) ? '' : 'created_at ' . $this->dateSort . '';

        //     $dataTables = MedicalHistory::with('employee')->orderByRaw('' . $dateSort . '');
        //     // $dataTables = $this->$dataTable;
        // } else {
        $dataTables = MedicalHistory::with('employee')->orderBy('created_at', 'ASC')->orderby($this->orderColumn, $this->sortOrder)
        // ->paginate(10, ['*'], 'page')
        ;
        // }

        // $employees = Employees::orderby($this->orderColumn, $this->sortOrder)->select('*');

        if ($this->statusFilter) {
            $dataTables->where('doctor_status_review', '' . $this->statusFilter . '');
        }

        if ($this->statusSort) {
            $dataTables->orderBy('doctor_status_review', '' . $this->statusSort . '');
        }

        if ($this->departmentFilter) {
            $dataTables->whereHas('employee', function ($q) {
                $q->where('department', $this->departmentFilter);
            });
            // ->where('department', '' . $this->departmentFilter . '');
        }

        // if ($this->departmentSort) {
        //     $dataTables->orderBy('department', '' . $this->departmentSort . '');
        // }

        if ($this->searchTerm) {

            $dataTables->whereHas('employee', function ($q) {
                $q->where('name', 'like', "%" . $this->searchTerm . "%");
            });

            $dataTables->orWhere('frammingham_risk_level', 'like', "%" . $this->searchTerm . "%");
            $dataTables->orWhere('doctor_status_review', 'like', "%" . $this->searchTerm . "%");

            // Player::whereHas('roleplay', function($q){
            //     $q->where('column_name', 'value');
            //  })->get();
        }

        $this->countData = $dataTables->count();
        $dataTables = $dataTables->paginate($this->limit);
        return view('livewire.mcu.medical-staff.tables', [
            'dataTables' => $dataTables,
        ]);

        // return view('livewire.emp-pagination', [
        //      'employees' => $employees,
        // ]);
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
            // $this->selectedID[] = $id;

        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }
}
