<?php

namespace Modules\DocumentSystem\Http\Livewire\ActiveDocument;

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\AreaManager;

use Modules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Entities\Category;
use Modules\DocumentSystem\Entities\Mapping;
use Modules\DocumentSystem\Entities\Document;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\DocumentSystem\UploadType;
use App\Enums\DocumentSystem\DocumentStatus;

class CreateDocument extends Component
{
    use WithFileUploads;

    //define opiton value
    public $companies = [];
    public $departments = [];
    public $sections = [];
    public $pjs = [];

    public $modules = [];
    public $categories = [];
    public $mapping = [];
    public $user;

    //define wire:model
    public $company = '';
    public $department = '';
    public $section = '';
    public $pj = '';
    public $module = '';
    public $category = '';
    public $map = '';
    public $jenis_upload = '';
    public $jenis_doc = '';
    public $sop_number = '';
    public $win_number = '';
    public $form_number = '';
    public $title = '';
    public $doc_created = '';
    public $invitedPeople = [];
    public $inputInvited = '';
    public $description = '';
    public $docs = [];

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount()
    {
        $this->user = User::inRandomOrder()->first();
        $this->companies = Company::all();
        $this->modules = Module::all();
    }

    public function updatedCompany()
    {
        $this->departments = Department::where('company_id', $this->company)->get();
    }

    public function updatedDepartment()
    {
        if ($this->department) {
            $this->sections = Section::where('department_id', $this->department)->get();
            return;
        }
    }

    public function updatedSection()
    {
        if ($this->section) {
            $this->pjs = AreaManager::where('section_id', $this->section)->with('user')->get();
            return;
        }
    }


    public function updatedModule()
    {
        if ($this->module) {
            $this->categories = Category::where('module_id', $this->module)->get();
            return;
        }
    }

    public function updatedCategory()
    {
        if ($this->category) {
            $this->mapping = Mapping::where('category_id', $this->category)->get();
            return;
        }
    }

    public function addInvitedPeople()
    {
        if (in_array($this->inputInvited, $this->invitedPeople)) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon' => 'success',
                'text'  => 'Email sudah ada'
            ]);
            return;
        }
        $this->invitedPeople[] = $this->inputInvited;
        $this->inputInvited = '';
    }
    public function removeInvited($email)
    {
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);
    }

    public function render()
    {
        return view('documentsystem::livewire.active-document.create-document')->extends('documentsystem::layouts.no-header');
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
        $data = [
            'status' => DocumentStatus::Draft()->value,
            'department_id' => $this->department,
            'mapping_id' => $this->map,
            'mapping_id' => $this->map,
            'area_manager_id' => $this->pj,
            'related_people' => json_encode($this->invitedPeople),
            'upload_type' => $this->jenis_upload,
            'document_level' => $this->jenis_doc,
            'title' => $this->title,
            'description' => $this->description,
            'sop_number' => $this->sop_number,
            'sop_add_win' => $this->win_number,
            'sop_add_form' => $this->form_number,
            'user_id' => $this->user->id,
        ];

        $document = Document::create($data);
        if ($document) {
            return redirect()->route('document-systems::active-document');
        }
    }

    public function saveToReview()
    {
        $this->validate();
        $data = [
            'status' => DocumentStatus::WaitingReview()->value,
            'department_id' => $this->department,
            'mapping_id' => $this->map,
            'mapping_id' => $this->map,
            'area_manager_id' => $this->pj,
            'related_people' => json_encode($this->invitedPeople),
            'upload_type' => $this->jenis_upload,
            'document_level' => $this->jenis_doc,
            'title' => $this->title,
            'description' => $this->description,
            'sop_number' => $this->sop_number,
            'sop_add_win' => $this->win_number,
            'sop_add_form' => $this->form_number,
            'user_id' => $this->user->id,
        ];

        $document = Document::create($data);
        if ($document) {
            return redirect()->route('document-systems::active-document');
        }
    }
}
