<?php

namespace App\Http\Livewire\MainDashboard\StrategicProject;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\StrategicProject;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $description, $Id, $url;

    protected $rules = [
        'input.title' => 'required',
        'input.date'   => 'required|date',
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
            $StrategicProject = StrategicProject::where('id', $id)->first();
            $StrategicProject = json_decode($StrategicProject, true);
            $StrategicProject['date'] = date('Y-m-d', strtotime($StrategicProject['date']));
            $this->input = $StrategicProject;
            $this->description = $StrategicProject['description'];
        }
    }


    public function store()
    {

        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.title'   => 'required',
            'input.date'   => 'required|date',
            'input.description' => 'required'
        ];
        if (empty($this->Id)) {
            $validation['input.file'] = 'mimes:jpg,gif,png | max:50000';
        }
        $this->validate($validation);

        //input exist file
        $file = isset($input['file']) ? $input['file'] : null;
        if ($file) {
            //delete is exists file in store
            $getData = StrategicProject::where(
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
            $blobResult = uploadToBlobStorage($name, $tempPath, 'dashboard/strategic_project');
            $url = $blobResult['fileBlobUrl'] ?? null;
            $attc = $blobResult['fileBlobPathName'] ?? null;

            // Fallback to local public storage if Blob upload fails
            if (!$url) {
                $attc = $file->storePubliclyAs('strategi_project', $name, 'public');
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
        StrategicProject::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('strategic_project_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.strategic-project.create')
            ->extends('layouts.no-header');
    }
}
