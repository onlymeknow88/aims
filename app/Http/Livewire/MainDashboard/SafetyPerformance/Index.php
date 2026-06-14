<?php

namespace App\Http\Livewire\MainDashboard\SafetyPerformance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MainDashboard\SafetyPerformance;

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
        $data = SafetyPerformance::whereIn('id', $this->itemSelected)->delete();
    }

    public function AvailableChangeMany()
    {
        $true = SafetyPerformance::where(['visible' => 'true'])->count();
        $false = SafetyPerformance::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        SafetyPerformance::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }


    public function AvailableChange($id)
    {

        $data = SafetyPerformance::where('id', $id)->first();

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
        $data = SafetyPerformance::selectRaw("
                *,
                DATE_FORMAT(month, '%b %Y  ') as monthYear
            ")
            ->orderby('created_at', 'DESC')->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.safety-performance.index', ['data' => $data])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
