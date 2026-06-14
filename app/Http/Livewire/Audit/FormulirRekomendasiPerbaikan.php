<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

class FormulirRekomendasiPerbaikan extends Component
{
    public $nama_perusahaan = '';
    public $tanggal_audit = '';
    public $elemen_perbaikan = [];
    public $template_elemen = [];
    public $nama_auditor = '';
    public $tanggal_auditor = '';

    public function render()
    {
        return view('livewire.audit.formulir-rekomendasi-perbaikan')->extends('layouts.no-header');
    }

    public function addNewField(){
        $this->elemen_perbaikan[] = $this->template_elemen;

        // clear template
        $this->template_elemen = [];
        //dd($this->elemen_perbaikan);
    }

    public function removeField($index){
        //$key = array_search($index, $this->elemen_perbaikan);
        unset($this->elemen_perbaikan[$index]); 
    }
}
