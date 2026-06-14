<?php

namespace App\Http\Livewire\MainDashboard\Slideshow;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

use App\Models\MainDashboard\Slideshow;

class Index extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $itemSelectedAll = [];

    public $countSelected;
    public $dataAll = [];

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
        $data = Slideshow::whereIn('id', $this->itemSelected)->get();
        foreach ($data  as $list) {
            try {
                Storage::delete($list->attc);
            } catch (\exception $e) {
            }
            $list->delete();
        }
    }

    public function AvailableChangeMany()
    {
        $true = Slideshow::where(['visible' => 'true'])->count();
        $false = Slideshow::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        Slideshow::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }


    public function AvailableChange($id)
    {
        $data = Slideshow::where('id', $id)->first();

        if ($data->visible == 'true') {
            $visible = 'false';
        } else {
            $visible = 'true';
        }
        $data->update(['visible' => $visible]);
        $this->render();
    }

    public function render()
    {
        $data = Slideshow::paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.slideshow.index', [
            'data' => $data
        ])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
