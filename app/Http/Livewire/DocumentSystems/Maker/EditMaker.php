<?php

namespace App\Http\Livewire\DocumentSystems\Maker;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;

class EditMaker extends Component
{
    use WithFileUploads;
    
    //define opiton value
    public $companies = [];
    public $departments = [];
    public $pjs = [];
    public $modules = [];
    public $categories = [];
    public $mapping = [];
    public $users = [];
    public $docs = [];

    //define wire:model
    public $company = '1';
    public $department = '1';
    public $pj = '';
    public $module = '1';
    public $category = '1';
    public $map = '1';
    public $user = [];
    public $jenis_upload = 'document';
    public $jenis_doc = 'sop';
    public $sop_number = '123';
    public $win_number = '123';
    public $form_number = '123';
    public $title = 'Title Document';
    public $doc_created = 'January 31, 2023';
    public $pjSelected = '98575e4b-cec7-4196-b3b0-870748bbe9e3';
    public $invitedPeople = [
        'sophie.walker@gmail.com',
        'andrew.walsh@gmail.com'
    ];
    public $inputInvited = '';
    public $description = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';

    public function mount(){

        $this->company1 = '1';

        $this->companies = [
            [
                'id' => 1,
                'name'  => 'PT Lahai Coal'
            ],
            [
                'id' => 2,
                'name'  => 'Company Name 2'
            ],
            [
                'id' => 3,
                'name'  => 'Company Name 3'
            ],
            [
                'id' => 4,
                'name'  => 'Company Name 4'
            ]
        ];

        $this->departments = [
            [
                'id' => 1,
                'name'  => '1. Mining & Engineering'
            ],
            [
                'id' => 2,
                'name'  => 'Department 2'
            ],
            [
                'id' => 3,
                'name'  => 'Department 3'
            ],
            [
                'id' => 4,
                'name'  => 'Department 4'
            ]
        ];

        $this->pjs  = User::all();

        $this->modules = [
            [
                'id' => 1,
                'name'  => '1. Kebijakan'
            ],
            [
                'id' => 2,
                'name'  => 'Modules 2'
            ],
            [
                'id' => 3,
                'name'  => 'Modules 3'
            ],
            [
                'id' => 4,
                'name'  => 'Modules 4'
            ]
        ];

        $this->categories = [
            [
                'id' => 1,
                'name'  => '1.1 Kebijakan PT MC'
            ],
            [
                'id' => 2,
                'name'  => 'Categories 2'
            ],
            [
                'id' => 3,
                'name'  => 'Categories 3'
            ],
            [
                'id' => 4,
                'name'  => 'Categories 4'
            ]
        ];

        $this->mapping = [
            [
                'id' => 1,
                'name'  => 'Mapping 1'
            ],
            [
                'id' => 2,
                'name'  => 'Mapping 2'
            ],
            [
                'id' => 3,
                'name'  => 'Mapping 3'
            ],
            [
                'id' => 4,
                'name'  => 'Mapping 4'
            ]
        ];

        $this->users = [
            [
                'id' => 1,
                'name'  => 'User 1',
                'email' => 'sophie.walker@gmail.com',
                'avatar'    => ''
            ],
            [
                'id' => 2,
                'name'  => 'User 2',
                'email' => 'andrew.walsh@gmail.com'
            ],
            [
                'id' => 3,
                'name'  => 'User 3',
                'email' => 'joanne.young@gmail.com'
            ],
            [
                'id' => 4,
                'name'  => 'User 4',
                'email' => 'andrew.mackenzie@gmail.com'
            ]
        ];

    }

    public function render()
    {
        return view('livewire.document-systems.maker.edit-maker');
    }

    public function addInvitedPeople(){
        //dd($this->inputInvited);
        if(in_array($this->inputInvited, $this->invitedPeople)){
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon'=>'success',
                'text'  => 'Email sudah ada'
            ]);
        }else{
            $this->invitedPeople[] = $this->inputInvited;
            $this->inputInvited = '';
        } 
    }
    public function removeInvited($email){
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);        
    }
}
