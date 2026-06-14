<?php

namespace App\Http\Livewire\MainDashboard\K3lhAward;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

use App\Models\MainDashboard\K3lhAward;

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
        $data = K3lhAward::whereIn('id', $this->itemSelected)->delete();
    }

    protected $listeners = ['search'];
    public function search($search)
    {
        $this->search = $search;
        $this->render();
    }

    public function AvailableChangeMany()
    {
        $true = K3lhAward::where(['visible' => 'true'])->count();
        $false = K3lhAward::where(['visible' => 'false'])->count();

        if ($true > $false) {
            $visible = 'false';
        } else {
            $visible = 'true';
        }

        K3lhAward::whereIn('id', $this->itemSelected)->update(['visible' => $visible]);
        $this->render();
    }

    public function AvailableChange($id)
    {
        $data = K3lhAward::where('id', $id)->first();

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
        $data = K3lhAward::where('company', 'like', '%' . $this->search . '%')
            ->orderBy('rank', 'ASC')
            ->orderBy('grade', 'ASC')
            ->selectRaw("
                *,
                DATE_FORMAT(month, '%b %Y') as monthYear
            ")
            ->paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.k3lh-award.index', [
            'data' => $data
        ])->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
