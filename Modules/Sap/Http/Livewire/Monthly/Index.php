<?php

namespace Modules\Sap\Http\Livewire\Monthly;

use Livewire\Component;

class Index extends Component
{
    public $data = [];
    public $columns = [];

    public $itemSelected = [];
    public $countSelected;
    public $search = null;
    public $dataAll = [];

    public function SelectAll()
    {
        $plucked = collect($this->dataAll)->pluck('id');
        $plucked->all();
        if (count($this->itemSelected) == 0) {
            $this->itemSelected = $plucked;
        } else {
            $this->itemSelected = [];
        }
    }
    
    public function SelectRow($row)
    {
        $id = $row['id'];
        //array found
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
        }
        //array not found
        else {
            $this->itemSelected[] = $id;
        }
        $this->countSelected = count($this->itemSelected);
    }

    public function confirmDelete()
    {
        /*  $data = NewsAndUpdate::whereIn('id', $this->itemSelected)->get();
        foreach ($data  as $list) {
            if ($list->attc) {
                Storage::delete($list->attc);
            }
            $list->delete();
        } */
    }


    public function render()
    {
        return view('sap::livewire.monthly.index')
            ->extends('sap::layouts.dashboard-white');
    }
}
