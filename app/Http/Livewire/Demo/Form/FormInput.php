<?php

namespace App\Http\Livewire\Demo\Form;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use DateTime;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormInput extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $companies = [];
    public $departments = [];
    public $docs;
    public $company = '';
    public $department = '';
    public $datepicker;   
    public $stnk=[]; 
    public $test=[];
    public $yesno = false;
    public $texteditor = '<p>test</p>';
 
    //public $files = []; 
    
    public function mount(){

        $dt = new DateTime();
        $this->datepicker = $dt->format('d F Y');
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

    }

    public function hydrate()
    {
        $this->emit('select2');
    }
    // public function finishUpload($name, $tmpPath, $isMultiple) 
    // {
    //     $this->cleanupOldUploads();
 
    //     // $files = collect($tmpPath)->map(function ($i) {
    //     //     return TemporaryUploadedFile::createFromLivewire($i);
    //     // })->toArray();
    //     $this->emitSelf('upload:finished', $name, collect($this->stnk)->map->getFilename()->toArray());
 
    //     //$files = array_merge($this->getPropertyValue($name), $files);
    //     $this->syncInput($name, $files);
    //     //dd($files);
    // }
    protected $listeners = [
        'confirmed'
    ];
    public function save(){

        $this->alert('question', 'How are you today?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'position' => 'center',
            'onConfirmed' => 'confirmed'
        ]);        
       
        
    }
    public function confirmed()
    {        
        $this->flash('success','Hello!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('demo-form');     
    }
    public function render()
    {
        return view('livewire.demo.form.form-input')->extends('layouts.no-header');
    }
    public function updatedCompany()
    {
        $this->texteditor = '<p>test update</p>';
        $this->dispatchBrowserEvent('size-updated');
    }
}
