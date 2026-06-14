<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

class SusunanKegiatan extends Component
{   
    public $tanggal, $waktu, $fungsi, $auditor;
    public $templateKegiatan = [];
    public $listKegiatan = [];
    public $i = 1;

    public function mount(){
        //$this->listKegiatan[] = ['kegiatan' => ['taggal' => '']];
    }
    public function render()
    {
        return view('livewire.audit.susunan-kegiatan')->extends('layouts.no-header');
    }
    public function addNewKegiatan($index_parent){ 
        $index_parent = $index_parent + 1;
        $this->i = $index_parent;
        array_push($this->listKegiatan ,$index_parent);
    }

    public function removeHaris($index_parent){
        unset($this->listKegiatan[$index_parent]);
        //$this->i--; 
        //$this->listKegiatan = array_values($this->listKegiatan);
    }
}
