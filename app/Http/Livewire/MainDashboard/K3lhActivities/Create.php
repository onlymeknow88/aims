<?php

namespace App\Http\Livewire\MainDashboard\K3lhActivities;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\K3lhActivities;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $description, $Id, $url;
    public $file;

    protected $rules = [
        'input.title' => 'required',
        'input.description' => 'required',
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
            $K3lhActivities = K3lhActivities::where('id', $id)->first();
            $K3lhActivities = json_decode($K3lhActivities, true);
            $this->input = $K3lhActivities;
            $this->description = $K3lhActivities['description'];
            $this->url = $K3lhActivities['attc'];
            $this->file = null;
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
            'file' => 'nullable|mimes:jpg,jpeg,png,gif|max:50000'
        ];

        $this->validate($validation);

        //input exist file
        $file = $this->file;
        if ($file) {
            //delete is exists file in store
            $getData = K3lhActivities::where(
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
            $blobResult = uploadToBlobStorage($name, $tempPath, 'dashboard/k3lh_activities');
            $url = $blobResult['fileBlobUrl'] ?? null;
            $attc = $blobResult['fileBlobPathName'] ?? null;

            // Fallback to local public storage if Blob upload fails
            if (!$url) {
                $attc = $file->storePubliclyAs('k3lh_activities', $name, 'public');
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
        $input['slug'] = Str::slug($input['title'], '-');
        $input['user_id'] = Auth::id();
        $input['visible'] = 'true';
        unset($input['id']);
        K3lhActivities::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('k3lh_activities_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.k3lh-activities.create')
            ->extends('layouts.no-header');
    }
}
