<?php

namespace App\Http\Livewire\MainDashboard\K3lhActivities;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

use App\Models\MainDashboard\K3lhActivities;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $countSelected;
    public $search;
    public $itemSelectedAll = [];
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
        $data = K3lhActivities::whereIn('id', $this->itemSelected)->get();
        foreach ($data  as $list) {
            if ($list->attc) {
                Storage::delete($list->attc);
            }
            $list->delete();
        }
    }

    protected $listeners = ['search'];
    public function search($search)
    {
        $this->search = $search;
        $this->render();
    }

    public function AvailableChangeMany()
    {
        $true = K3lhActivities::where(['visible' => 'true'])->count();
        $false = K3lhActivities::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        K3lhActivities::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }


    public function AvailableChange($id)
    {    
        $data = K3lhActivities::where('id', $id)->first();

        if ($data->visible == 'true') {
            $visible = 'false';
        } else {
            $visible = 'true';
        }
        $data->update(['visible'=> $visible]);
        $this->render();
    }

    public function render()
    {
        $data = K3lhActivities::select('dashboard_k3lh_activities.*', DB::raw("LEFT(description, 200) as description"))
            ->where('title', 'like', '%' . $this->search . '%')
            ->orwhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('created_at','DESC')
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.k3lh-activities.index', [
            'data' => $data
        ])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
