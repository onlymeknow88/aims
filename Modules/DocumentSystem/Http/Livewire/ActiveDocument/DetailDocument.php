<?php

namespace Modules\DocumentSystem\Http\Livewire\ActiveDocument;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Modules\DocumentSystem\Entities\Document;
use App\Models\User;

class DetailDocument extends Component
{
    use WithFileUploads;

    public $document;
    public $attachs = [];
    public $description = '';
    public $user;

    public function mount(Request $request)
    {
        $this->document = Document::with([
            'department.company',
            'areaManager' => function ($q) {
                $q->with(['user', 'section']);
            },
            'mapping.category.module',
            'activities.user'
        ])->find($request->id);

        $this->user = User::latest()->first();
    }


    public function render()
    {
        return view('documentsystem::livewire.active-document.detail-document')->extends('documentsystem::layouts.no-header');
    }

    public function saveActivity()
    {
        // store file if exists
        if ($this->attachs) {
            foreach ($this->attachs as $key => $file) {
                $this->attachs[$key] = $file->store('document-systems-files');
            }
        }

        $status = $this->document->status;
        //update document status to return
        $this->document->updateToReview();

        //input data activity
        $activity = [
            'description' => $this->description,
            'user_id' => $this->user->id,
            'status_document' => $status
        ];

        if ($this->attachs) {
            $activity['attachments'] = json_encode($this->attachs);
        }

        $this->document->activities()->create($activity);

        return redirect()->route('document-systems::active-document');
    }
}
