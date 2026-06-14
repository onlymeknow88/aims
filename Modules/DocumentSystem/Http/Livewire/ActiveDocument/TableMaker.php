<?php

namespace Modules\DocumentSystem\Http\Livewire\ActiveDocument;

use Livewire\Component;
use Modules\DocumentSystem\Entities\Document;

class TableMaker extends Component
{
    public $document = [];
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            //array_merge($this->itemSelected, array($this->itemSelected[$key]));
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            ///array_push($this->itemSelected, $id);
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    public function render()
    {
        $this->document = Document::with([
            'department.company',
            'mapping.category.module',
            'areaManager.user'
        ])->get();
        return view('documentsystem::livewire.active-document.table-maker');
    }
}
