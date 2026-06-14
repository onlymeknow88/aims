<?php

namespace App\Http\Livewire\MainDashboard\StrategicProject;

use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use App\Models\MainDashboard\StrategicProject;

class Index extends Component
{

    use WithPagination;

    public $itemSelected = [];
    public $countSelected;
    public $search;
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
        $data = StrategicProject::whereIn('id', $this->itemSelected)->get();
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
        $true = StrategicProject::where(['visible' => 'true'])->count();
        $false = StrategicProject::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        StrategicProject::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }

    public function AvailableChange($id)
    {
        $data = StrategicProject::where('id', $id)->first();

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
        $data = StrategicProject::orderby('created_at', 'DESC')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orwhere('description', 'like', '%' . $this->search . '%')
            ->select('dashboard_strategic_project.*', DB::raw("LEFT(description, 200) as description"))
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.strategic-project.index', ['data' => $data])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
