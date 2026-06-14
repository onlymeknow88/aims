<?php

namespace App\Http\Traits\DocumentSystems;

use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\AreaManager;
use App\Models\User;

use App\Models\DocumentSystem\Module;
use App\Models\DocumentSystem\Category;
use App\Models\DocumentSystem\Mapping;
use App\Models\DocumentSystem\Document;

use App\Enums\DocumentSystem\UploadType;
use App\Enums\DocumentSystem\DocumentStatus;
use App\Enums\DocumentSystem\DocumentLevel;
use Carbon\Carbon;

trait DocumentTrait 
{
    public $companies = [];
    public $modules = [];
    public $user = '';
    public $activForm;
    public $document = '';
    
    public $departments = [];
    public $sections = [];
    public $pjs = [];
    public $categories = [];
    public $mapping = [];
    
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
    public $doc_created='';
    public $doc_number='';
    public $invitedPeople = [];
    public $inputInvited = '';
    public $description = '';
    public $docs = '';
    public $fileUpload;
    public $attachments;
    
    public function updatedCompany(){
        $this->departments = Department::where('company_id', $this->company)->get();
    }

    public function updatedDepartment(){
        if($this->department) {
            $this->sections = Section::where('department_id', $this->department)->get();
            return;
        }
    }

    public function updatedSection(){
        if($this->section) {
            $this->pjs = AreaManager::where('section_id', $this->section)->with('user')->get();
            return;
        }
    }
    
    public function updatedModule(){
        if($this->module) {
            $this->categories = Category::where('module_id', $this->module)->get();
            return;
        }
    }

    public function updatedCategory(){
        if($this->category) {
            $this->mapping = Mapping::where('category_id', $this->category)->get();
            return;
        }
    }

    public function updatedSopNumber(){
        $item = Document::where('sop_number', $this->sop_number)->whereIn('status', [
            DocumentStatus::Obsolate()->value, DocumentStatus::Approved()->value
        ])->where('document_level', DocumentLevel::Sop()->value)->first();
        
        if($item) {
            $this->activForm = true;
            return;
        }

        $this->activForm = false;
        
    }

    public function addInvitedPeople(){
        if(in_array($this->inputInvited, $this->invitedPeople)){
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon'=>'success',
                'text'  => 'Email sudah ada'
            ]);
            return;
        }
        $this->invitedPeople[] = $this->inputInvited;
        $this->inputInvited = '';
         
    }
    
    public function removeInvited($email){
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);        
    }

    public function getDataInsert()
    {
        return [
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
            'doc_created' => Carbon::parse($this->doc_created)->format('Y-m-d'),
            'user_id' => $this->user->id,
            'document_number' => $this->doc_number,
        ];
    }
}