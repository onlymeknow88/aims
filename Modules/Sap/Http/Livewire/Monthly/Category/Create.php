<?php

namespace Modules\Sap\Http\Livewire\Monthly\Category;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Modules\Sap\Entities\SapDepartments;
use Modules\Sap\Entities\SapDepartmentCodes;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $slug,  $Id, $url, $department_codes;

    protected $rules = [
        'input.name' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id = null)
    {
        //show is exist
        if ($id) {
            $this->Id = $id;
            $data = SapDepartments::where('id', $id)->first();
            $data = json_decode($data, true);
            $this->input = $data;
        }


        //nama departemnt
        $deptCode = SapDepartmentCodes::select('code', 'department_id')->get();
        $this->department_codes = $deptCode;
    }


    public function store()
    {
        //input
        $input = $this->input;
        $input['slug'] = Str::slug($input['name'], '-');
        $this->slug = $input['slug'];

        //validate
        $validation = [
            'input.name' => 'required',
        ];

        if ($this->Id) {
            $validation['slug'] = 'required|unique:sap_monthly_category,id,' . $this->Id;
        } else {
            $validation['slug'] = 'required|unique:sap_monthly_category';
        }

        $response = [
            'slug.unique' => 'The name has already been taken.'
        ];

        $this->validate($validation, $response);

        //create or update
        $input['user_id'] = Auth::id();;
        unset($input['id']);
        SapDepartments::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('sap-monthly-category-index');
    }


    public function render()
    {
        return view('sap::livewire.monthly.category.create')
            ->extends('sap::layouts.dashboard-white');
    }
}
