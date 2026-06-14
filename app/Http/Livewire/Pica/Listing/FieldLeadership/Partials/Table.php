<?php

namespace App\Http\Livewire\Pica\Listing\FieldLeadership\Partials;


use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Exports\FieldLeadershipExport;
use App\Models\FieldLeadership;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Table extends Component
{
    use WithPagination;

    public $limit = 100;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Date', 'CCOW', 'Company', 'Detail Company', 'Department', 'Section', 'Location', 'Detail Location', 'Type', 'Members', 'Positive Condition', 'Risk Condition', 'Repair Action', 'Status'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldDetailCompany;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldDetailCompany = FieldLeadership::where('published', FieldLeadershipType::Publish)->get()->groupBy('detail_company')->toBase();

        $this->countData = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->get()->count();
    }

    // BEGIN::SORTING
    public function sort($type, $field)
    {
        $this->sortType = $type;
        $this->sortField = $field;
    }

    public function sortCheck($field, $value)
    {
        $this->sortFieldSelected = $field;

        if (in_array($value, $this->sortSelected)) {
            $key = array_search($value, $this->sortSelected);
            unset($this->sortSelected[$key]);
        } else {
            $this->sortSelected[] = $value;
        }
    }
    // END::SORTING

    // BEGIN::SEARCH
    public function searchUpdated($search)
    {
        $this->search = $search;
    }
    // END::SEARCH

    // BEGIN::COLUMN
    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'selectedColumns') {
            $this->showColumn($value);
        }

        if ($propertyName == 'limit') {
            $this->limit = $value;
        }
    }
    // END::COLUMN

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        return FieldLeadership::when(!empty($this->sortSelected), function ($query) {
            $query->whereIn($this->sortFieldSelected, $this->sortSelected);
        })
            ->where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::Open)
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortType)
            ->paginate($this->limit);
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            //array_merge($this->itemSelected, array($this->itemSelected[$key]));
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            ///array_push($this->itemSelected, $id);
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $fl = FieldLeadership::find($item);

            $fl->members()->delete();

            $fl->positives()->delete();

            if (isset($fl->risks->files)) {
                foreach ($fl->risks->files as $file) {
                    $file->delete();
                }
            }

            $fl->risks()->delete();

            $fl->delete();
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text'  => 'Data berhasil di hapus'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function exportExcel()
    {
        $now = Carbon::now()->toDateTimeString();
        return Excel::download(new FieldLeadershipExport($this->itemSelected), "Field_Leadership_$now.xlsx");
    }

    public function render()
    {
        return view('livewire.pica.listing.field-leadership.partials.table')->layout('livewire.pica.layouts.app');
    }
}
