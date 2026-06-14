<?php

namespace Modules\Sap\Http\Livewire\Setup\Grade\Category;

use Livewire\Component;
use Livewire\WithPagination;

use Modules\Sap\Entities\SapSetupCategory;
use Modules\Sap\Entities\SapSetup;

class Index extends Component
{
    use WithPagination;
    public $columns = [];
    public $itemSelected = [];
    public $countSelected;
    public $available;
    public $search = null;
    public $dataAll = [];

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

    public function SelectRow($id)
    {
        //array found
        $itemSelected = is_array($this->itemSelected) ? $this->itemSelected : [];
        
        if (in_array($id, $itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
        }
        //array not found
        else {
            $this->itemSelected[] = $id;
        }
    }

    public function confirmDelete()
    {
        $data = SapSetupCategory::whereIn('id', $this->itemSelected)->get();
        foreach ($data as $list) {
            $list->setupList()->delete();
            $list->delete();
        }

        session()->flash('message', 'Data Berhasil Dihapus.');
    }

    public function AvailableChange($id = null)
    {
        SapSetupCategory::where('id', '!=', $id)->update(['available' => 'false']);
        SapSetup::where('category_id', '!=', $id)->update(['available' => 'false']);

        $SapSetupCategory = SapSetupCategory::where('id', $id)->first();
        if ($SapSetupCategory->available == "true") {
            $status = "false";
        } else {
            $status = "true";
        }
        $SapSetupCategory->update(['available' => $status]);
        $SapSetupCategory->setup()->update(['available' => $status]);

        $this->available = $id;
        $this->emit('setupUpdate');
        $this->render();
    }


    public function render()
    {
        $data = SapSetupCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderby('created_at', 'ASC')
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('sap::livewire.setup.grade.category.index', ['data' => $data])
            ->extends('sap::layouts.dashboard-white');
    }
}
