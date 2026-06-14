<?php

namespace Modules\Sap\Http\Livewire\Setup\Grade;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Modules\Sap\Entities\SapSetupCategory;
use Modules\Sap\Entities\SapSetup;
use App\Access\ApiModules;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $category_id, $category_name, $input, $Id, $url;
    public $safety_accountability_progam = [
        'Inspection',
        'FL - Planned Task Observation',
        'FL - Take Time Talk',
        'FL - Hazard Report'
    ];

    protected $rules = [
        'input.safety_accountability_progam' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($category_id = null, $id = null)
    {
        if ($category_id) {
            $data = SapSetupCategory::where('id', $category_id)->first();
            $this->category_name = $data ? $data->name : null;
            $this->category_id = $category_id;
        }
        //show is exist
        if ($id) {
            $this->Id = $id;
            $slideshow = SapSetup::where('id', $id)->first();
            $slideshow = json_decode($slideshow, true);
            $this->input = $slideshow;
        }
    }


    public function store()
    {
        //validate
        $validation = [
            'input.safety_accountability_progam' => 'required'
        ];
        $this->validate($validation);

        //input
        $input = $this->input;

        //kategory
        $catagory = SapSetupCategory::where('id', $this->category_id)->first();

        //create or update
        $input['slug'] = Str::slug($input['safety_accountability_progam'], '-');
        $input['user_id'] = Auth::id();
        $input['year'] = $catagory->name;
        $input['available'] =  'true';
        unset($input['id']);

        $catagory->setup()->updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('sap-setup-index', $this->category_id);
    }

    public function render()
    {
        $apiFL = ApiModules::module('field_leadership');
        if ($apiFL['status'] == 'true') {
            $category = collect($apiFL['data']['barChartByCategory'])->map(function ($q, $key) {
                return 'FL - ' . $q['name'];
            });
            $this->safety_accountability_progam = $category;
        }

        return view('sap::livewire.setup.grade.create')
            ->extends('layouts.no-header');
        //->extends('sap::layouts.dashboard-white');
    }
}
