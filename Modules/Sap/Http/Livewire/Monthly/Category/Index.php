<?php

namespace Modules\Sap\Http\Livewire\Monthly\Category;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Modules\Sap\Http\Controllers\Api\ApiSapController;

use Modules\Sap\Entities\SapMonthlyCategory;
use Modules\Sap\Entities\SapMonthlyEmployee;
use App\Access\dateSetup;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Sap\Exports\DataPersonal;
use Modules\Sap\Imports\MonthlyEmployeeImport;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $data = [];
    public $dataAll = [];

    public $personal_data = [];
    public $filters = [];

    public $loading = false;
    public $apiResponse;
    public $dataCategory;
    public $category_id;

    public $data_employee = [];

    public $columns = [];
    public $itemSelected = [];
    public $countSelected;

    public $itemSelectedEmployee = [];
    public $countSelectedEmployee;
    public $available;

    public $value;
    public $search = null;
    public $year = null;
    public $tahun = null;
    public $month = null;
    public $department = null;
    public $dept = null;
    public $grade = null;

    public $edit_input = [];
    public $months = [];
    public $filter = [
        'search' => null,
        'year' => null,
        'month' => null,
        'department' => null,
        'dept' => null,
        'grade' => null,
    ];

    public $import_file;

    protected $rules = [
        'value' => 'numeric',
        'import_file' => 'nullable|file|mimes:xls,xlsx,csv',
    ];
    protected $messages = [];
    protected $validationAttributes = [];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($slug = null)
    {

        //ambil dari query url
        if (Request()->get('month')) {
            $month = Request()->get('month');
            $this->filter['month'] = $month;
        }

        if (Request()->get('year')) {
            $this->filter['year'] = Request()->get('year');
        } else {
            $this->filter['year'] = date('Y');
        }

        if (Request()->get('department')) {
            $this->filter['department'] = Request()->get('department');
        }
        if (Request()->get('grade')) {
            $this->filter['grade'] = Request()->get('grade');
        }


        $this->tahun =  $this->filter['year'];
        $this->months = dateSetup::month($this->filter['year']);
        $this->dataCategory = SapMonthlyCategory::all();

        $this->submitFilter(['filter' => $this->filter]);
    }


    protected $listeners = ['search', 'filter', 'submitFilter'];

    public function search($search)
    {
        $this->filter['search'] = $search;
        $this->search = $search;
        $this->getData();
    }


    public function filter($filter)
    {
    }

    public function submitFilter($filter)
    {
        $this->loading = true;
        $filter = $filter['filter'];
        foreach ($filter as $index => $item) {
            $this->filter[$index] = $item;
            $this->{$index} = $item;
        }
        $this->year = $filter['year'] ? $filter['year'] : date('Y');
        $this->tahun = $filter['year'] ? $filter['year'] : date('Y');

        $month = $this->filter['month'];
        $monthArray = explode(",", $month);
        if (count($monthArray) > 0 && $month != null) {
            $months = dateSetup::month($this->year);
            $months = collect($months)->whereIn('month', $monthArray);
            $months = $months->values()->all();
            $this->months =  $months;
        } else {
            $month = dateSetup::month($this->year);
            $this->months =  $month;
        }
        $this->getData();
    }


    public $itemSelectedAll = [];

    public function SelectAll()
    {
        $data = $this->data;
        $employee_id = [];
        foreach ($data as $kategory) {
            foreach ($kategory['employee_list'] as $employee) {
                $employee_id[] = $employee['id_employee'];
            }
        }

        if (count($this->itemSelectedAll) > 0) {
            $this->itemSelectedEmployee =  $employee_id;
        } else {
            $this->itemSelectedEmployee = [];
        }
        $this->countSelectedEmployee = count($this->itemSelectedEmployee);
    }

    public function SelectRow($id)
    {
        //array found
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
        }
        //array not found
        else {
            $this->itemSelected[] = $id;
        }
        $this->countSelected = count($this->itemSelected);
    }

    public function confirmDelete()
    {
        $data = SapMonthlyCategory::whereIn('id', $this->itemSelected)->get();
        foreach ($data as $list) {
            $list->employeeList()->delete();
            $list->delete();
        }
        session()->flash('message', 'Data Berhasil Dihapus.');
    }

    public function confirmDeleteDepartement($id)
    {
        $data = SapMonthlyCategory::doesntHave('employeeList')
            ->where('id', $id)
            ->first();

        if ($data) {
            $data->delete();
            $this->emit('toastAlert', ['icon' => 'success', 'text' => 'Berhasil dihapus']);
            return ''; //session()->flash('message', 'Data Berhasil Dihapus.');
        }
        $this->emit('toastAlert', ['icon' => 'error', 'text' => 'Tidak dapat dihapus']);
        return ''; // session()->flash('message', 'Tidak dapat dihapus.');
    }

    public function SelectRowEmployee($id = null)
    {
        //array found
        if (in_array($id, $this->itemSelectedEmployee)) {
            $key = array_search($id, $this->itemSelectedEmployee);
            unset($this->itemSelectedEmployee[$key]);
        }
        //array not found
        else {
            $this->itemSelectedEmployee[] = $id;
        }
        $this->countSelectedEmployee = count($this->itemSelectedEmployee);
    }

    public function confirmDeleteEmployee()
    {
        $data = SapMonthlyEmployee::whereIn('id', $this->itemSelectedEmployee)->get();
        $this->data_employee = $data;

        foreach ($data as $list) {
            $list->monthlyList()->delete();
            $list->delete();
        }
        session()->flash('message', 'Data Berhasil Dihapus.');
    }


    public function MoveCategory($category_id = null)
    {
        $this->category_id =  $category_id;

        $data = SapMonthlyEmployee::whereIn('id', $this->itemSelectedEmployee)->get();
        $this->data_employee = $data;

        if ($category_id) {
            foreach ($data as $list) {
                $list->update([
                    'category_id' => $category_id
                ]);
            }
        }
        session()->flash('message', 'Data Berhasil Dipindahkan.');
    }

    public function AvailableChange($id = null)
    {
        $SapSetupCategory = SapMonthlyCategory::where('id', $id)->first();
        if ($SapSetupCategory->available == "true") {
            $status = "false";
        } else {
            $status = "true";
        }

        $SapSetupCategory->update(['available' => $status]);
        $this->available = $id;
    }


    public function edit($id_employee)
    {
        //$employee = SapMonthlyEmployee::where('id', $id_employee)->first();
        $this->edit_input = json_decode($id_employee, true);
        $this->emit('openEmployeModal');
    }


    public function UpdateMonth($id = null, $month = null, $value = null)
    {
        $this->value = $value;
        $this->validate();

        $year = $this->year;
        SapMonthlyEmployee::where('id', $id)
            ->first()
            ->monthlyList()
            ->updateOrCreate(['year' => $year], ['user_id' => Auth::id(), $month => $value]);

        $this->emit('toastAlert', ['icon' => 'success', 'text' => 'success']);
    }


    public function importExcel()
    {
        $this->validate([
            'import_file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        try {
            Excel::import(new MonthlyEmployeeImport, $this->import_file->getRealPath());
            $this->emit('importSuccess', 'Import berhasil!');
        } catch (\Exception $e) {
            $this->emit('importSuccess', 'Import gagal: ' . $e->getMessage());
        }

        $this->reset('import_file');
    }

    public function getData()
    {
        $request = Request();
        $request['year'] = $this->year;
        $request['search'] = $this->search;
        $request['grades'] = $this->grade;
        $request['departments'] = $this->department;
        $request['months'] = $this->month;
        $data = (new ApiSapController)->PersonalData($request);
        $this->personal_data = $data['data'];
        $this->data = $data['data'];
        $this->filters = $data['filter'];

        return $data['data'];
    }


    public function download()
    {
        $data = $this->getData();
        $months = $this->months;
        $filename = 'personal-data ' . date('d-m-Y H:i:s') . '.xlsx';
        return Excel::download(new DataPersonal($months, $data), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function render()
    {
        return view('sap::livewire.monthly.category.index')
            ->extends('sap::layouts.dashboard-white');
    }
}
