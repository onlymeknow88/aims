<?php

namespace App\Http\Livewire\MainDashboard\Banner;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\Banner;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input = [];
    public $Id, $file, $url, $index;

    protected $rules = [
        'input.name' => 'required',
        'input.description' => 'required',
        'input.file' => 'mimes:jpeg,png,jpg,gif | max:50000',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function mount($id = null)
    {
        if ($id) {
            $this->Id = $id;
            $get = Banner::where('id', $id)->first();
            $this->input = json_decode($get, true);
        }
    }


    public function store()
    {
        Banner::where('visible', 'true')->update(['visible' => 'false']);
        $input = $this->input;
        $input['visible'] = 'true';
        //validate
        $validation = [
            'input.name' => 'required',
            'input.description' => 'required',
        ];

        $exist = Banner::where(['id' => $this->Id])->first();
        if (empty($exist)) {
            $validation['input.file'] = 'required | mimes:jpeg,png,jpg,gif | max:50000';
        } else {
            $validation['input.file'] = 'mimes:jpeg,png,jpg,gif | max:50000';
        }

        $this->validate($validation);
        //input exist file
        $name = $input['name'];
        $file = $input['file'];
        if ($file) {
            //delete is exists file in store
            $getData = Banner::where(
                ['name' => $name]
            )->first();

            if ($getData) {
                if ($getData->attc) {
                    Storage::delete($getData->attc);
                }
            }

            //save file
            $ext = $file->extension();
            $nameSlug = Str::slug($name, '-');
            $nameFile = $nameSlug . strtotime(now()) . '.' . $ext;
            $attc = $file->storePubliclyAs('banner', $nameFile, 'public');
            $url = Storage::url($attc);
        }

        if ($file) {
            $input['attc'] = $attc;
            $input['url'] = $url;
        }

        //create or update
        $input['user_id'] = Auth::id();;
        Banner::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('banner_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.banner.create')
            ->extends('layouts.no-header');
    }
}
