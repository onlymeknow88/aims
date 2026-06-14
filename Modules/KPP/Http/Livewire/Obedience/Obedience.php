<?php

namespace Modules\KPP\Http\Livewire\Obedience;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\KPP\Entities\KppObedience as ObedienceModel;
use Modules\KPP\Entities\KppRule;

class Obedience extends Component
{
    use WithPagination;

    public $limit;
    public $countData;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $columns = ['Nomor Peraturan', 'Judul Peraturan', 'Status Peraturan', 'Draft Ekstraksi', 'Submitted Ekstraksi', 'Date Created'];

    //'CCOW', 'Contractor', 'Subcontractor',

    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $sortType = 'desc';
    public $sortField = 'created_at';
    public $sortSelected = [];
    public $sortFieldSelected;
    public $searchNumber;
    public $searchTitle;
    public $fieldType;
    public $fieldAgencyAuthority;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $company_id = Auth::user()->department->company->id;
        $last = ObedienceModel::where('company_id', $company_id)->latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        //column search
        //$this->fieldType = KppRuleType::all();
        //$this->fieldAgencyAuthority = KppAgencyAuthority::all();

        $this->countData = ObedienceModel::where('company_id', $company_id)->get()->count();
        $this->limit = $this->countData;
    }

    public function removeItemFilter($field)
    {
        if ($field == 'searchNumber') {
            $this->searchNumber = null;
        }

        if ($field == 'searchTitle') {
            $this->searchTitle = null;
        }
    }

    // BEGIN::SORTING
    public function sort($type, $field)
    {
        $this->sortType = $type;
        $this->sortField = $field;
    }

    public function sortCheck($field, $value)
    {
        // dd($this->sortSelected);

        $this->sortFieldSelected = $field;

        if (!empty($this->sortSelected[$this->sortFieldSelected])) {
            if (in_array($value, $this->sortSelected[$this->sortFieldSelected])) {
                $key = array_search($value, $this->sortSelected[$this->sortFieldSelected]);

                unset($this->sortSelected[$this->sortFieldSelected][$key]);
                if (empty($this->sortSelected[$this->sortFieldSelected])) {
                    unset($this->sortSelected[$this->sortFieldSelected]);
                }
            } else {

                $this->sortSelected[$this->sortFieldSelected][] = $value;
            }
        } else {
            $this->sortSelected[$this->sortFieldSelected][] = $value;
        }

        $this->removeSeleced();

        //dd($this->sortSelected);
    }
    // END::SORTING

    // BEGIN::SEARCH
    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }
    // END::SEARCH

    // BEGIN::COLUMN
    public function searchUpdated($search)
    {
        $this->search = $search;
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'selectedColumns') {
            $this->showColumn($value);
        }

        if ($propertyName == 'limit') {
            if ($value > $this->countData) {
                $this->limit = $this->countData;
            } else {
                $this->limit = $value;
            }
        }
    }
    // END::COLUMN

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function getObediencesProperty(): LengthAwarePaginator
    {
        DB::statement("SET SQL_MODE=''");
        $company_id = Auth::user()->department->company->id;
        $obediences = ObedienceModel::where('company_id', $company_id)->latest();
        return ObedienceModel::where('company_id', $company_id)->latest()
            ->whereHas('rule', function ($query) {
                $query->where('status', '!=', 'Dicabut');
            })
            ->when(!empty($this->searchNumber), function ($query) {
                $query->whereHas('rule', function ($q) {
                    $q->where('number', 'like', '%' . $this->searchNumber . '%');
                });
            })
            ->when(!empty($this->searchTitle), function ($query) {
                $query->where('title', 'like', '%' . $this->searchTitle . '%');
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortType)
            ->latest()
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

    public function render()
    {
        return view('kpp::livewire.obedience.obedience')->layout('kpp::layouts.app');
    }
}
