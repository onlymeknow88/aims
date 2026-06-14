<?php

namespace Modules\Mcu\Http\Livewire\MedicalStaff;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Mcu\Entities\MedicalHistory;
use Modules\Mcu\Exports\MedicalHistoryExport;
use Modules\Mcu\Imports\MedicalHistoryImport;

class ListInReview extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;

    public $limit, $doctorStatusReview;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Nama Pasien', 'Tanggal MCU', 'Tanggal Pembuatan', 'Perusahaan', 'Departemen', 'Status Kesehatan'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $idSelected;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $selectAll = false;
    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldCompany, $fieldDepartment, $filterMcuDate, $filterMcuDate2, $filterCreatedDate, $filterCreatedDate2, $searchName, $searchDepartment;

    public $excelFile;
    public $dataTable;
    public $carbonNow;

    protected $rules = ['excelFile' => 'required|file|mimes:xlsx, xls'];
    protected $paginationTheme = 'bootstrap';

    protected $messages = [
        'excelFile.required' => 'Anda belum memilih file excel',
    ];

    protected $listeners = [
        'confirmDelete',
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $mcu = MedicalHistory::where('staff_id', auth()->user()->employee->id)
            // ->where('doctor_status_review', 'In Review')
            ->whereNull('doctor_certificate_number');
        $this->countData = $mcu->count();
        $this->limit = $this->countData;
        $this->latestUpdate = 'Update on ' . Carbon::parse($mcu->latest('updated_at')->first()->updated_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::get();
        $this->fieldDepartment = Department::all();
    }

    public function sort($type, $field)
    {
        $this->sortType = $type;
        $this->sortField = $field;
    }

    public function sortCheck($field, $value)
    {
        $this->sortFieldSelected = $field;

        if (!empty($this->sortSelected[$this->sortFieldSelected])) {
            if (in_array($value, $this->sortSelected[$this->sortFieldSelected])) {
                $key = array_search($value, $this->sortSelected[$this->sortFieldSelected]);

                unset($this->sortSelected[$this->sortFieldSelected][$key]);
                if (empty($this->sortSelected[$this->sortFieldSelected])) {
                    unset($this->sortSelected[$this->sortFieldSelected]);
                }
            } else {
                $this->sortSelected[$this->sortFieldSelected][] = $value;
            }
        } else {
            $this->sortSelected[$this->sortFieldSelected][] = $value;
        }
    }

    public function searchUpdated($search)
    {
        $this->search = $search;
    }

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'selectedColumns') {
            $this->showColumn($value);
        }

        if ($propertyName == 'limit') {
            if ($value > $this->countData) {
                $this->limit = $this->countData;
            } else {
                $this->limit = $value;
            }
        }
    }

    public function getMcuDatasProperty()
    {
        return MedicalHistory::when(!empty($this->sortSelected), function ($query) {
            $query->where(function ($query) {
                $query->when($this->sortFieldSelected == 'company_id', function ($query) {
                    if (array_key_exists('company_id', $this->sortSelected)) {
                        $query->whereHas('employee', function ($query) {
                            $query->whereHas('user', function ($query) {
                                $query->whereHas('department', function ($query) {
                                    $query->whereIn('company_id', $this->sortSelected['company_id']);
                                });
                            });
                        });
                    };
                })->when($this->sortFieldSelected == 'department_id', function ($query) {
                    if (array_key_exists('department_id', $this->sortSelected)) {
                        $query->whereHas('employee', function ($query) {
                            $query->whereHas('user', function ($query) {
                                $query->whereHas('department', function ($query) {
                                    $query->whereIn('id', $this->sortSelected['department_id']);
                                });
                            });
                        });
                    };
                })->when($this->sortFieldSelected == 'doctor_status_review', function ($query) {
                    array_key_exists('doctor_status_review', $this->sortSelected) ? $query->whereIn('doctor_status_review', $this->sortSelected['doctor_status_review']) : '';
                });
            });
        })->when(!empty($this->filterMcuDate && !empty($this->filterMcuDate2)), function ($query) {
            $from = Carbon::parse($this->filterMcuDate)->format('Y-m-d');
            $to = Carbon::parse($this->filterMcuDate2)->format('Y-m-d');

            $query->whereBetween('mcu_date', [$from, $to]);
        })->when(!empty($this->filterCreatedDate && !empty($this->filterCreatedDate2)), function ($query) {
            $from = Carbon::parse($this->filterCreatedDate)->format('Y-m-d');
            $to = Carbon::parse($this->filterCreatedDate2)->format('Y-m-d');

            $query->whereBetween('created_at', [$from, $to]);
        })->when(!empty($this->searchName), function ($query) {
            $query->whereHas('employee', function ($query) {
                $query->where('name', 'like', '%' . $this->searchName . '%');
            });
        })->when(!empty($this->searchDepartment), function ($query) {
            $query->whereHas('employee', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchDepartment . '%');
                    });
                });
            });
        })->with('employee')
            ->orderByRaw("FIELD(doctor_status_review ,'In Review', 'Unfit', 'Fit With Recomendation', 'Curently Unfit', 'Fit') ASC")
            ->orderBy('created_at', 'DESC')
            ->where('staff_id', auth()->user()->employee->id)
            // ->where('doctor_status_review', 'In Review')
            ->where('doctor_status_review', '!=', 'draft')
            ->whereNull('doctor_certificate_number')
            ->orderBy($this->sortField, $this->sortType)
            ->paginate($this->limit);
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

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectAll = false;
        } else {
            $this->selectAll = true;
        }

        if (!$this->selectAll) {
            // Deselect all items
            $this->itemSelected = [];
            $this->selectAll = false;
            $this->countSelected = 0;
        } else {
            // Select all items
            $this->itemSelected = $this->McuDatas->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->McuDatas->count();

            $this->itemSelected = $this->itemSelected->toArray();
        }
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
            $this->status = $selectedData->doctor_status_review;
        }
    }

    public function delete()
    {
        foreach ($this->itemSelected as $item) {
            $mcu = MedicalHistory::find($item);

            DB::beginTransaction();

            $mcu->delete();

            DB::commit();
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data berhasil di hapus',
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $mcu = MedicalHistory::find($item);
            $mcu->delete();
        }

        $this->flash('success', 'Data berhasil di hapus!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
        redirect()->route('mcu::medical-staff-in-review');
    }

    public function import()
    {
        $this->validate();
        Excel::import(new MedicalHistoryImport, $this->excelFile);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data MCU berhasil di import',
        ]);
        redirect()->route('mcu::medical-staff');
    }

    public function export()
    {
        $file_name = "MCU-export-" . Carbon::now()->format('d-m-y-h-i-s') . "";

        return Excel::download(new MedicalHistoryExport($this->itemSelected), '' . $file_name . '.xlsx');
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('MCU - View List MCU Medical Staff')) {
            return view('mcu::livewire.medical-staff.list-in-review')->layout('mcu::layouts.app');
        } else {
            return abort(404);
        }
    }
}
