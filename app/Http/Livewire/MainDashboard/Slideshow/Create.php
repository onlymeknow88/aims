<?php

namespace App\Http\Livewire\MainDashboard\Slideshow;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\Slideshow;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $Id, $url;
    public $file;

    protected $rules = [
        'input.name' => 'required',
        'input.description' => 'required',
        'file' => 'nullable|mimes:mp4,mov,ogg,qt|max:50000'
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
            $slideshow = Slideshow::where('id', $id)->first();
            $this->input = json_decode($slideshow, true);
        }
    }


    public function store()
    {
        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.name'   => 'required',
            'input.description' => 'required',
            'file' => 'required|mimes:mp4,mov,ogg,qt|max:50000'
        ];

        $exist = Slideshow::where(['id' => $this->Id])->first();
        //jika create
        if (empty($exist)) {
            $validation['file'] = 'required|mimes:mp4,mov,ogg,qt|max:50000';
        } else {
            $validation['file'] = 'nullable|mimes:mp4,mov,ogg,qt|max:50000';
        }


        $this->validate($validation);

        //input exist file
        $file = $this->file;
        if ($file) {
            //delete is exists file in store
            $getData = Slideshow::where(
                ['id' => $this->Id]
            )->first();
            if ($getData) {
                if ($getData->attc) {
                    Storage::delete($getData->attc);
                }
            }

            //save file
            $ext = $file->extension();
            $nameSlug = Str::slug($input['name'], '-');
            $name = $nameSlug . strtotime(now()) . '.' . $ext;
            $attc = $file->storePubliclyAs('slideshow', $name, 'public');
            $url = Storage::url($attc);
        }

        if ($file) {
            $input['attc'] = $attc;
            $input['url'] = $url;
        }

        //create or update
        $input['user_id'] = Auth::id();
        $input['visible'] = 'true';
        unset($input['id']);
        Slideshow::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('slideshow_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.slideshow.create')
            ->extends('layouts.no-header');
    }
}
