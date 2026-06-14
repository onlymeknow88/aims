<?php

namespace Modules\Sap\Http\Livewire\Setup\Grade;

use Livewire\Component;
use Modules\Sap\Entities\SapSetup;
use Livewire\WithPagination;
use Modules\Sap\Entities\SapSetupCategory;

class Index extends Component
{
    use WithPagination;

    public $category_id;
    public $category_name;

    public $columns = [];
    public $itemSelected = [];
    public $countSelected;
    public $search = null;
    public $dataAll = [];

    public function mount($category_id = null)
    {
        $this->category_id = $category_id;
    }


    public $itemSelectedAll = [];

    public function SelectAll()
    {
        $plucked = collect($this->dataAll)->pluck('id');
        $plucked->all();
        if (count($this->itemSelectedAll) > 0) {
            $this->itemSelected = $plucked;
        } else {
            $this->itemSelected = [];
        }
        $this->countSelected = count($this->itemSelected);
    }

    public function SelectRow($row)
    {
        $id = $row;
        //array found
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected ?? []);
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
        $data = SapSetup::whereIn('id', $this->itemSelected)->delete();
        session()->flash('message', 'Data Berhasil Dihapus.');
    }

    public function render()
    {
        $data = SapSetupCategory::where('id', $this->category_id)->first();
        $this->category_name = $data->name;

        $data = $data->setupList()
            ->where('safety_accountability_progam', 'like', '%' . $this->search . '%')
            ->selectRaw("
                sap_setup.*,

                CASE  WHEN sap_setup.dept_head = '0.00' THEN '0'
                    ELSE sap_setup.dept_head
                END AS  dept_head,

                CASE  WHEN sap_setup.foreman_supervisor_sechead = '0.00' THEN '0'
                    ELSE sap_setup.foreman_supervisor_sechead
                END AS foreman_supervisor_sechead,

                CASE  WHEN sap_setup.employee = '0.00' THEN '0'
                    ELSE sap_setup.employee
                END AS  employee
                ")
            ->orderby('created_at', 'ASC')
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('sap::livewire.setup.grade.index', ['data' => $data])
            ->extends('sap::layouts.dashboard-white');
    }
}


/* 
                CASE  WHEN sap_setup.dforeman_supervisor_sechead = '0.00' THEN ''
                    ELSE sap_setup.foreman_supervisor_sechead
                END AS  sap_setup.dforeman_supervisor_sechead,
                CASE  WHEN sap_setup.employee = '0.00' THEN ''
                    ELSE sap_setup.employee
                END AS  employee */