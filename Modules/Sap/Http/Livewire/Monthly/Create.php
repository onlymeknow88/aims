<?php

namespace Modules\Sap\Http\Livewire\Monthly;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Modules\Sap\Entities\SapDepartments;
use Modules\Sap\Entities\SapEmployees;
use Modules\Sap\Entities\SapDepartmentCodes;

use Modules\Sap\Entities\SapMonthlyEmployee;
use Modules\Sap\Entities\SapMonthlyCategory;

use App\Models\User;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;


    public $category_id, $category_name, $input, $Id, $url, $department_codes, $users, $user_name, $search;

    protected $rules = [
        'input.name' => 'required',
        'input.department' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($category_id = null, $id = null)
    {
        if ($category_id) {
            $data = SapMonthlyCategory::where('id', $category_id)->first();
            if ($data) {
                $data['department_name'] =  $data['name'];
                $this->category_name = $data ? $data->name : null;
                $this->category_id = $category_id;
            }
        }

        //show is exist
        if ($id) {
            $this->Id = $id;
            $data = SapMonthlyEmployee::where('id', $id)->first();
            $data = json_decode($data, true);
            $this->input = $data;
        }
    }



    public function store()
    {
        //input
        $input = $this->input;
        unset($input['id']);

        //departemtns
        $inputCategory = $input;
        unset($inputCategory['name']);

        if (isset($input['department_name'])) {
            $inputCategory['name'] = $input['department_name'];
            $inputCategory['slug'] = Str::slug($input['department_name'], '-');
        }

        $category =  SapMonthlyCategory::updateOrCreate(
            ['code' => $input['code']],
            $inputCategory
        );

        //employee
        $category->employeeList()->updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('sap-monthly-category-index');
    }

    public function Users()
    {
        $users = User::leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->orwhere('employees.id_number', 'LIKE', '%' . $this->search . '%')
            ->orwhere('employees.name', 'LIKE', '%' . $this->search . '%')
            ->get();
        $this->users = $users;
    }

    public function selectUser($employee_name, $employee_number)
    {
        $users = User::leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->leftJoin('department_codes', 'department_codes.department_id', '=', 'users.department_id')
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->leftJoin('companies', 'companies.user_id', '=', 'users.id')
            ->where('employees.id_number', $employee_number)
            ->selectRaw("
                department_codes.code,
                departments.name as department_name,
                companies.company_name,
                users.department_id,
                users.name,
                employees.user_id,
                employees.id_number
            ")
            ->first();

        $this->input = json_decode($users, true);
    }

    public function DepartmentCodes()
    {
        $deptCode = SapDepartmentCodes::select('code', 'department_id')->get();
        $this->department_codes = $deptCode;
    }

    public function render()
    {
        //nama departemnt

        $this->DepartmentCodes();
        $this->Users();

        return view('sap::livewire.monthly.create')
            ->extends('layouts.no-header');
        // ->extends('sap::layouts.dashboard-white');
    }
}
