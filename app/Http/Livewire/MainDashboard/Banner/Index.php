<?php

namespace App\Http\Livewire\MainDashboard\Banner;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

use App\Models\MainDashboard\Banner;

class Index extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $itemSelectedAll = [];

    public $countSelected;
    public $dataAll = [];
    public $Id;

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
        $data = Banner::whereIn('id', $this->itemSelected)->get();
        foreach ($data  as $list) {
            try {
                Storage::delete($list->attc);
            } catch (\Throwable $e) {
            }
            $list->delete();
        }
    }


    public function AvailableChangeMany()
    {
        $true = Banner::where(['visible' => 'true'])->count();
        $false = Banner::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        Banner::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }


    public function AvailableChange($id)
    {

        Banner::where('id', '!=', $id)->where('visible', 'true')->update(['visible' => 'false']);

        $data = Banner::where('id', $id)->first();
        $this->Id = $data;

        if ($data->visible == 'true') {
            $visible = 'false';
        } else {
            $visible = 'true';
        }
        $data->update(['visible' => $visible]);
        $this->render();
    }

    public function getData()
    {
        $data = Banner::Orderby('created_at', 'DESC')->paginate(10);
        $this->dataAll = $data->items();
    }

    public function render()
    {
        $data = Banner::Orderby('created_at', 'DESC')->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.banner.index', [
            'data' => $data
        ])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
