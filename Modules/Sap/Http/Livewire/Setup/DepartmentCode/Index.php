<?php

namespace Modules\Sap\Http\Livewire\Setup\DepartmentCode;

use Modules\Sap\Entities\SapDepartmentCodes;
use Livewire\Component;

class Index extends Component
{
    public $codes = [];
    public $itemSelected = [];

    public function mount()
    {
        $this->Codes();
    }

    public function  selectAddCode($id)
    {
        $getRow =  SapDepartmentCodes::where('id', $id)->first();
        if ($getRow->type == 'department') {
            $getRow->update(['type' => null]);
        } else {
            $getRow->update(['type' => 'department']);
        }
        $this->Codes();
    }

    public function Codes()
    {
        $this->codes = SapDepartmentCodes::whereNull('type')
            ->orWhere('type', '!=', 'department')
            ->get();
    }


    public function SelectRow($code)
    {
        $id = $code;
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
        } else {
            $this->itemSelected[] = $id;
        }
    }

    public function confirmSelectedUpdate()
    {
        SapDepartmentCodes::whereIn('id', $this->itemSelected)->update(['type' => null]);
        $this->Codes();
        $this->itemSelected = [];
    }

    public function render()
    {
        $data = SapDepartmentCodes::where('type', 'department')->get();
        return view('sap::livewire.setup.department-code.index', ['data' => $data])
            ->extends('sap::layouts.dashboard-white');
    }
}
