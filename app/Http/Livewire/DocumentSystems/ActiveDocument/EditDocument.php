<?php

namespace App\Http\Livewire\DocumentSystems\ActiveDocument;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use App\Http\Traits\DocumentSystems\DocumentTrait;

use App\Models\User;
use App\Models\Company;
use App\Models\DocumentSystem\Module;
use App\Models\DocumentSystem\Document;
use App\Enums\DocumentSystem\DocumentStatus;
use Carbon\Carbon;

class EditDocument extends Component
{
    use WithFileUploads, DocumentTrait;

    public function mount(Request $request)
    {
        $this->document = Document::with([
            'department.company',
            'areaManager'=>function($q) {
                $q->with(['user', 'section']);
            },
            'mapping.category.module',
            'activities.user'
        ])->find($request->id);
        // dd($document);


        $this->user = User::inRandomOrder()->first();
        $this->companies = Company::all();
        $this->modules = Module::all();

        $this->company = $this->document->department->company->id;
        $this->section = $this->document->areaManager->section->id;
        $this->department = $this->document->department_id;
        $this->pj = $this->document->area_manager_id;
        
        $this->module = $this->document->mapping->category->module->id;
        $this->category = $this->document->mapping->category->id;
        $this->map = $this->document->mapping_id;

        $this->jenis_upload = $this->document->upload_type;
        $this->jenis_doc = $this->document->document_level;
        $this->sop_number = $this->document->sop_number;
        $this->win_number = $this->document->sop_add_win;
        $this->form_number = $this->document->sop_add_form;
        $this->title = $this->document->title;
        $this->doc_created = Carbon::create($this->document->created_at)->format('Y-m-d');
        $this->invitedPeople = json_decode($this->document->related_people);
        $this->description = $this->document->description;
        

        $this->updatedCompany();
        $this->updatedDepartment();
        $this->updatedDepartment();
        $this->updatedSection();
        $this->updatedModule();
        $this->updatedCategory();
    }

    public function hydrate()
    {
        $this->emit('select2');
    }


    public function render()
    {
        return view('livewire.document-systems.active-document.edit-document')->extends('layouts.no-header');
    }

    protected $rules = [
        'company' => 'required',
        'department' => 'required',
        'section' => 'required',
        'pj' => 'required',
        'module' => 'required',
        'category' => 'required',
        'map' => 'required',
        'jenis_upload' => 'required',
        'jenis_doc' => 'required',
        'invitedPeople.*' => 'required',
        'title' => 'required',
        'doc_created' => 'required',
        'description' => 'required',
    ];


    public function saveToDraft()
    {   
        $this->validate();
        $data = $this->getDataInsert();
        $data['status'] = DocumentStatus::Draft()->value;
        $this->document->fill($data)->save();

        return redirect()->route('document-systems::active-document.detail', ['id' => $this->document->id]);
    }

    public function saveToReview()
    {
        $this->validate();
        $data = $this->getDataInsert();
        $data['status'] = DocumentStatus::WaitingReview()->value;
        $this->document->fill($data)->save();
        
        return redirect()->route('document-systems::active-document.detail', ['id' => $this->document->id]);
    }
}
