<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use App\Models\User;

class FormulirRencanaTidakLanjut extends Component
{
    public $itemSelected = [];
    public $countSelected = 0;
    public $limit = 50;

    public function render()
    {
        return view('livewire.audit.formulir-rencana-tidak-lanjut',[
            'users' => User::paginate($this->limit),
        ])->extends('layouts.no-header');
    }

    public function onSelectedItem($id){
        
        if(in_array($id, $this->itemSelected)){
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        }else{
            $this->itemSelected[] = $id;
             $this->countSelected++;
        }        
        
    }

    public function removeSeleced(){
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

}
