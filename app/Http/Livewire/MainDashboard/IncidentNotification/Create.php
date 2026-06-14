<?php

namespace App\Http\Livewire\MainDashboard\IncidentNotification;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\IncidentNotification;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $Id, $url;

    protected $rules = [
        'input.date' => 'required|date',
        'input.case' => 'required',
        'input.description' => 'required',
        'input.category' => 'required',
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
            $slideshow = IncidentNotification::where('id', $id)->first();
            $slideshow = json_decode($slideshow, true);
            $slideshow['date'] = date('Y-m-d', strtotime($slideshow['date']));
            $this->input = $slideshow;
        }
    }


    public function store()
    {
        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.date' => 'required|date',
            'input.case' => 'required',
            'input.description' => 'required',
            'input.category' => 'required',
        ];

        $this->validate($validation);


        //input exist file
        $file = isset($input['file']) ? $input['file'] : null;
        if ($file) {
            //delete is exists file in store
            $getData = IncidentNotification::where(
                ['id' => $this->Id]
            )->first();
            if ($getData) {
                if ($getData->attc) {
                    Storage::delete($getData->attc);
                }
            }

            //save file
            $ext = $file->extension();
            $nameSlug = Str::slug($input['case'], '-');
            $name = $nameSlug . strtotime(now()) . '.' . $ext;
            $attc = $file->storePubliclyAs('news_and_update', $name, 'public');
            $url = Storage::url($attc);
        }

        if ($file) {
            $input['attc'] = $attc;
            $input['url'] = $url;
        }

        //create or update
        $input['user_id'] = Auth::id();
        $input['slug'] = Str::slug($input['case'], '-');
        $input['visible'] = 'true';

        unset($input['id']);
        IncidentNotification::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('incident_notification_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.incident-notification.create')
        ->extends('layouts.no-header');
    }
}
