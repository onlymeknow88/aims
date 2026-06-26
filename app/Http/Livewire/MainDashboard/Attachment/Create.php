<?php

namespace App\Http\Livewire\MainDashboard\Attachment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\Attachment;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $Id, $url;

    protected $rules = [
        'input.name' => 'required',
        //'input.description' => 'required',
        'input.file' => 'mimes:pdf,doc,docx,xls,xlsx,ptt,pttx | max:50000'
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
            $Attachment = Attachment::where('id', $id)->first();
            $this->input = json_decode($Attachment, true);
        }
    }


    public function store()
    {
        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.name'   => 'required',
        ];
        if (empty($this->Id)) {
            $validation['input.file'] = 'required|mimes:pdf,doc,docx,xls,xlsx,ptt,pttx  | max:50000';
        } else {
            $validation['input.file'] = 'mimes:pdf,doc,docx,xls,xlsx,ptt,pttx  | max:50000';
        }
        $this->validate($validation);

        $count = Attachment::all()->count();
        if ($count >= 10 && empty($this->Id)) {
            return $this->addError('attachments', 'Max. 10 Attachments');
        }

        //input exist file
        $file = isset($input['file']) ? $input['file'] : null;
        if ($file) {
            //delete is exists file in store
            $getData = Attachment::where(
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

            // Upload directly to Blob Storage
            $tempPath = $file->getRealPath();
            $blobResult = uploadToBlobStorage($name, $tempPath, 'dashboard/attachments');
            $url = $blobResult['fileBlobUrl'] ?? null;
            $attc = $blobResult['fileBlobPathName'] ?? null;

            // Fallback to local public storage if Blob upload fails
            if (!$url) {
                $attc = $file->storePubliclyAs('attachments', $name, 'public');
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
        $input['user_id'] = Auth::id();
        unset($input['id']);
        Attachment::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('attachment_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.attachment.create')
            ->extends('layouts.no-header');
    }
}
