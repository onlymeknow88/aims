<?php

namespace App\Http\Livewire\DocumentSystems\Review;

use Livewire\Component;
use App\Models\DocumentSystem\Document;
use App\Enums\DocumentSystem\DocumentStatus;

class TableApproval extends Component
{
    public $document = [];
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

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

    public function activedInfo(){
        $this->info = !$this->info;
    }

    public function removeSeleced(){
        $this->itemSelected = [];
        $this->countSelected = 0;
    }


    public function render()
    {
        $this->document = Document::with(['department.company', 'mapping.category.module'])
            ->where('status', '!=', DocumentStatus::Draft()->value)
            ->get();
            
        return view('livewire.document-systems.review.table-approval');
    }
}
