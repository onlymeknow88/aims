<?php

namespace App\Http\Livewire\MainDashboard\NewsAndUpdate;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\NewsAndUpdate;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input,  $Id, $url;
    public $description;

    protected $rules = [
        'input.title' => 'required',
        'input.description' => 'required',
        'input.file' => 'mimes:jpg,gif,png | max:50000'
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
            $NewsAndUpdate = NewsAndUpdate::where('id', $id)->first();
            $NewsAndUpdate = json_decode($NewsAndUpdate, true);
            $this->input = $NewsAndUpdate;
        }
    }


    public function store()
    {
        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.title'   => 'required',
            'input.description' => 'required',
            'input.file' => 'mimes:jpg,gif,png | max:50000'
        ];

        $this->validate($validation);

        //input exist file
        $file = isset($input['file']) ? $input['file'] : null;
        if ($file) {
            //delete is exists file in store
            $getData = NewsAndUpdate::where(
                ['id' => $this->Id]
            )->first();
            if ($getData) {
                if ($getData->attc) {
                    Storage::delete($getData->attc);
                }
            }

            $ext = $file->extension();
            $nameSlug = Str::slug($input['title'], '-');
            $name = $nameSlug . strtotime(now()) . '.' . $ext;

            // Upload directly to Blob Storage
            $tempPath = $file->getRealPath();
            $blobResult = uploadToBlobStorage($name, $tempPath, 'dashboard/news_and_update');
            $url = $blobResult['fileBlobUrl'] ?? null;
            $attc = $blobResult['fileBlobPathName'] ?? null;

            // Fallback to local public storage if Blob upload fails
            if (!$url) {
                $attc = $file->storePubliclyAs('news_and_update', $name, 'public');
                $url = Storage::url($attc);
            }
        }

        if ($file) {
            $input['attc'] = $attc;
            $input['url'] = $url;
            $input['blob_url'] = $blobResult['fileBlobUrl'] ?? null;
            $input['blob_response'] = isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null;
        }

        //create or update
        $slug = Str::slug($input['title'], '-');
        $input['slug'] = $slug;
        $input['user_id'] = Auth::id();
        $input['visible'] = 'true';
        unset($input['id']);
        NewsAndUpdate::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('news_and_update_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.news-and-update.create')
        ->extends('layouts.no-header');
    }
}
