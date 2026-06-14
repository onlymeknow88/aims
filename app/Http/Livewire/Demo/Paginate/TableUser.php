<?php

namespace App\Http\Livewire\Demo\Paginate;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class TableUser extends Component
{
    use WithPagination;
    //protected $paginationTheme = 'bootstrap';

    public $itemSelected = [];
    public $filtered = false;
    public $countSelected = 0;
    public $latestUpdate = 'Update on Sep 24, 2022 . 15.00 pm';
    public $limit = 0;
    public $selectAll = false;

    public function mount(){
        $this->limit = 5;
    }

    public function render()
    {
        return view('livewire.demo.paginate.table-user',[
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

    public function toggleSelectAll(){
        $this->selectAll = ! $this->selectAll;
    }
}
