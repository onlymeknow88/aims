<?php

namespace App\Http\Livewire\MainDashboard\General;

use Livewire\Component;
use App\Models\MainDashboard\General;
use Livewire\WithPagination;

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
        General::whereIn('id', $this->itemSelected)
            ->delete();
    }

    public function AvailableChangeMany()
    {
        $true = General::where(['visible' => 'true'])->count();
        $false = General::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        General::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }

    public function AvailableChange($id)
    {

        General::where('id', '!=', $id)->where('visible', 'true')->update(['visible' => 'false']);

        $data =  General::where('id', $id)->first();
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
        $data = General::selectRaw("
            *,
            DATE_FORMAT(month, '%b %Y') as monthYear
             ")
            ->orderby('created_at', 'DESC')->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.general.index', [
            'data' => $data
        ])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
