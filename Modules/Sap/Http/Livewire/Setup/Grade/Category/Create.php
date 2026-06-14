<?php

namespace Modules\Sap\Http\Livewire\Setup\Grade\Category;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Access\dateSetup;

use Modules\Sap\Entities\SapSetupCategory;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input = [], $slug, $Id, $url, $years = [];
    public $tes;


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
            $slideshow = SapSetupCategory::where('id', $id)->first();
            $slideshow = json_decode($slideshow, true);
            $this->input = $slideshow;
        }

        $this->years = dateSetup::yearPlus();
    }


    public function store()
    {
        //input
        $input = $this->input;
        $name = isset($input['name']) ? $input['name'] : null;
        $input['slug'] = Str::slug($name, '-');
        $this->slug = isset($input['slug']) ? $input['slug'] : null;

        //validate
        $validation = [
            'input.name' => 'required',
        ];

        if ($this->Id) {
            $validation['slug'] = 'required|unique:sap_setup_category,id,' . $this->Id;
        } else {
            $validation['slug'] = 'required|unique:sap_setup_category,deleted_at,NULL';
        }

        $response = [
            'slug.unique' => 'The name has already been taken.'
        ];

        $this->validate($validation, $response);

        //create or update
        $input['user_id'] = Auth::id();
        $input['available'] =  'true';
        unset($input['id']);

        SapSetupCategory::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        // session()->flash('message', json_encode($input));
        $this->emit('toastAlert', ['icon' => 'success', 'text' => '']);
        return redirect()->route('sap-setup-category-index');
    }

    public function render()
    {
        return view('sap::livewire.setup.grade.category.create')
            ->extends('layouts.no-header');
        //->extends('sap::layouts.dashboard-white');
    }
}
