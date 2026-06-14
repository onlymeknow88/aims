<?php

namespace App\Http\Livewire\MainDashboard\IncidentNotification;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use DB;
use App\Models\MainDashboard\IncidentNotification;

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
        $data = IncidentNotification::whereIn('id', $this->itemSelected)->delete();
    }

    protected $listeners = ['search'];
    public function search($search)
    {
        $this->search = $search;
        $this->render();
    }

    public function AvailableChangeMany()
    {
        $true = IncidentNotification::where(['visible' => 'true'])->count();
        $false = IncidentNotification::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        IncidentNotification::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }


    public function AvailableChange($id)
    {
        $data = IncidentNotification::where('id', $id)->first();

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
        $data = IncidentNotification::where('case', 'like', '%' . $this->search . '%')
            ->select(
                DB::raw('DATE_FORMAT(date, "%d %b %Y") as date'),
                'id',
                'visible',
                'case',
                'category',
                'description',
                'slug'
            )
            ->orderBy('date', 'DESC')
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.incident-notification.index', ['data' => $data])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
