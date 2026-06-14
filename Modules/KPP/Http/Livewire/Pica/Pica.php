<?php

namespace Modules\KPP\Http\Livewire\Pica;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\KPP\Entities\KppExtraction as ExtractionModel;
use Modules\KPP\Entities\KppObedience;

class Pica extends Component
{
    use WithPagination;

    public $limit;
    public $countData;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $type = 'ayat';
    public $columns = ['ID Ekstraksi', 'Company', 'Nomor Peraturan', 'Judul Peraturan', 'Pasal', 'Ayat', 'Penanggung Jawab', 'Status', 'Comment', 'Date Created'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $sortType = 'desc';
    public $sortField = 'created_at';
    public $sortSelected = [];
    public $sortFieldSelected;
    public $searchNumber;
    public $fieldCompany;
    public $searchRuleNumber, $fieldRuleNumber;
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = ExtractionModel::exceptDraft()->latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::all();

        $this->countData = ExtractionModel::where('extraction_issue_flag', 1)
            ->get()->count();

        $this->limit = $this->countData;
    }

    public function removeItemFilter($field)
    {
        if ($field == 'company_id') {
            unset($this->sortSelected['company_id']);
            $this->sortFieldSelected = null;
        }

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

    public function getExtractionsProperty(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
        return ExtractionModel::where('extraction_issue_flag', 1)
            ->when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when(isset($this->sortSelected['company_id']), function ($query) {
                        $query->whereHas('obedience', function ($query) {
                            $query->whereIn('company_id', $this->sortSelected['company_id']);
                        });
                    });
                });
            })
            ->when(!empty($this->searchNumber), function ($query) {
                $query->whereHas('obedience', function ($query) {
                    $query->whereHas('rule', function ($query) {
                        $query->where('number', 'like', '%' . $this->searchNumber . '%');
                    });
                });
            })
            ->when(!empty($this->searchTitle), function ($query) {
                $query->whereHas('obedience', function ($query) {
                    $query->whereHas('rule', function ($query) {
                        $query->where('title', 'like', '%' . $this->searchTitle . '%');
                    });
                });
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortType)
            ->latest()
            //->where('responsible_id', Auth::user()->id)
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

    public function edit($id)
    {
        $type = KppObedience::find($id);

        $this->dispatchBrowserEvent('edit', $type);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $type = KppObedience::find($item);
            $type->delete();
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data berhasil di hapus'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('kpp::livewire.pica.pica')->layout('kpp::layouts.app');
    }
}
