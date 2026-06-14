<?php

namespace App\Http\Livewire\Demo\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Sorting extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $countSelected = 0;
    public $latestUpdate = 'Update on Sep 24, 2022 . 15.00 pm';
    public $countData = 0;
    public $limit = 100;

    public function mount(){
        $this->limit = 50;
    }

    public function render()
    {
        return view('livewire.demo.tables.sorting',[
            'users' => User::paginate($this->limit),
        ]);
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
