<?php

namespace Modules\KPP\Http\Livewire\Extraction\InReview;

use App\Enums\KPP\ExtractionStatus;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\KPP\Entities\KppExtraction as ExtractionModel;
use Modules\KPP\Entities\KppObedience;

class InReview extends Component
{
	use WithPagination;

    public $limit;
    public $countData;

	public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $type = 'ayat';
    public $patuh = 0;
    public $tidak_patuh = 0;
    public $tidak_berlaku = 0;
    public $in_progress = 0;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public $columns = ['ID Ekstraksi', 'Company', 'Nomor Peraturan', 'Judul Peraturan', 'Pasal', 'Ayat', 'Penanggung Jawab', 'Status', 'Date Created'];
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

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = ExtractionModel::exceptDraft()->latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::all();

        $this->countData = ExtractionModel::exceptDraft()
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
            if ($value > $this->countData) {
                $this->limit = $this->countData;
            } else {
                $this->limit = $value;
            }
        }
    }
    // END::COLUMN

    public function getExtractionsProperty(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
    	return ExtractionModel::onlyInReview()
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
            ->paginate($this->limit);


        $obediences = KppObedience::query();
        if ($request->has('type')) {
            $company_ids = Company::where('type', $request->type)->pluck('id');
            $obediences->whereIn('company_id', $company_ids);
        } else {
            $company_id = Auth::user()->department->company->id;
            $obediences->where('company_id', $company_id);
        }

        $extractions = ExtractionModel::exceptDraft();

        if ($request->status) {
            $status = $request->status;
            $extractions->where('status', ExtractionStatus::$status()->value);
        } else {
            $extractions->whereIn('obedience_id', $obediences->pluck('id'));
        }

        $extractions = $extractions->get();

        return $extractions;
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
            'text'  => 'Data berhasil di hapus'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('kpp::livewire.extraction.in-review.in-review')->layout('kpp::layouts.app');
    }
}
