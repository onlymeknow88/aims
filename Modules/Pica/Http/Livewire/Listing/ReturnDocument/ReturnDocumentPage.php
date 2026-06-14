<?php

namespace Modules\Pica\Http\Livewire\Listing\ReturnDocument;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\Pica\PicaStatus;
use App\Enums\PicaSource;
use App\Exports\FieldLeadershipExport;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\KPP\Http\Livewire\Pica\Pica;
use Modules\Pica\Entities\PicaDocument;

class ReturnDocumentPage extends Component
{
    use WithPagination, LivewireAlert;

    public $limit;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Identity ID', 'Source NCAR', 'Date', 'Initiator/Auditor', 'Company', 'Penanggung Jawab', 'KTT/PJO', 'Location', 'Work Activities', 'Description Non Compliance', 'Corrective Action', 'Target Settlement', 'Settlement Date', 'Status', 'Published'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $selectAll = false;
    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldSource;
    public $fieldCompany;
    public $fieldLocation;
    public $fieldStatus;

    public $searchIdentityId;
    public $searchAuditor;
    public $searchPja;
    public $searchPjo;

    public $startDate, $endDate;
    public $startDateTarget, $endDateTarget;
    public $startDateSettlement, $endDateSettlement;

    public $sourceId = [];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $pica = PicaDocument::with('pica')->where('published', PicaStatus::Publish)->get();

        foreach ($pica as $key => $value) {
            if (!empty($value->pica)) {
                $this->sourceId[] = $value->pica->source_id;
            }
        }

        $this->selectedColumns = $this->columns;

        $last = PicaDocument::latest()->first();

        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldSource = PicaDocument::where('published', PicaStatus::Publish)
            ->where('requested', PicaStatus::ReturnDocument)
            ->get()
            ->groupBy('source')
            ->toBase();

        $this->fieldCompany = PicaDocument::where('published', PicaStatus::Publish)
            ->where('requested', PicaStatus::ReturnDocument)
            ->get()
            ->groupBy('company_id')
            ->map(function ($item, $key) {
                return $item->first()->company->company_name;
            });

        $this->fieldLocation = PicaDocument::where('published', PicaStatus::Publish)
            ->where('requested', PicaStatus::ReturnDocument)
            ->get()
            ->groupBy('location_id')
            ->map(function ($item, $key) {
                return $item->first()->areaLocation->name;
            });

        $this->fieldStatus = PicaDocument::where('published', PicaStatus::Publish)
            ->where('requested', PicaStatus::ReturnDocument)
            ->get()
            ->groupBy('status')
            ->toBase();

        $this->countData = $this->activeListings->total();

        $this->limit = $this->countData;
    }

    // BEGIN::FILTER
    public function removeItemFilter($field)
    {
        if ($field == 'identity_id') {
            $this->searchIdentityId = null;
        }

        if ($field == 'source') {
            unset($this->sortSelected['source']);
        }

        if ($field == 'date') {
            $this->startDate = null;
            $this->endDate = null;
        }

        if ($field == 'auditor') {
            $this->searchAuditor = null;
        }

        if ($field == 'company_id') {
            unset($this->sortSelected['company_id']);
        }

        if ($field == 'pja') {
            $this->searchPja = null;
        }

        if ($field == 'pjo') {
            $this->searchPjo = null;
        }

        if ($field == 'location_id') {
            unset($this->sortSelected['location_id']);
        }

        if ($field == 'dateTarget') {
            $this->startDateTarget = null;
            $this->endDateTarget = null;
        }

        if ($field == 'dateSettlement') {
            $this->startDateSettlement = null;
            $this->endDateSettlement = null;
        }
    }
    // END::FILTER

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
    }
    // END::SORTING

    // BEGIN::SEARCH
    public function searchUpdated($search)
    {
        if (!empty($search)) {
            $this->searchCompany = null;
            $this->searchDepartment = null;
            $this->searchSection = null;
            $this->searchLocation = null;
            $this->sortSelected = [];

            $this->search = $search;
        } else {
            $this->search = null;
        }
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

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        return PicaDocument::when(!empty($this->sortSelected), function ($query) {
            $query->where(function ($query) {
                $query->when(isset($this->sortSelected['source']), function ($query) {
                    $query->whereIn('source', $this->sortSelected['source']);
                })
                    ->when(isset($this->sortSelected['company_id']), function ($query) {
                        $query->whereIn('company_id', $this->sortSelected['company_id']);
                    })
                    ->when(isset($this->sortSelected['location_id']), function ($query) {
                        $query->whereIn('location_id', $this->sortSelected['location_id']);
                    });
            });
        })
            ->when(!empty($this->searchIdentityId), function ($query) {
                $query->where('identity_id', 'like', '%' . $this->searchIdentityId . '%');
            })
            ->when(!empty($this->searchAuditor), function ($query) {
                $query->where('auditor', 'like', '%' . $this->searchAuditor . '%');
            })
            ->when(!empty($this->searchPja), function ($query) {
                $query->whereHas('pja', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchPja . '%');
                    });
                });
            })
            ->when(!empty($this->searchPjo), function ($query) {
                $query->whereHas('pjo', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchPjo . '%');
                });
            })
            ->when(!empty($this->search), function ($query) {
                $query->search($this->search);
            })
            ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                $query->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->when(!empty($this->startDateTarget) && !empty($this->endDateTarget), function ($query) {
                $query->whereBetween('target_settlement_date', [$this->startDateTarget, $this->endDateTarget]);
            })
            ->when(!empty($this->startDateSettlement) && !empty($this->endDateSettlement), function ($query) {
                $query->whereBetween('settlement_date', [$this->startDateSettlement, $this->endDateSettlement]);
            })
            ->where('published', PicaStatus::Publish)
            ->where('requested', PicaStatus::ReturnDocument)
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

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectAll = false;
        } else {
            $this->selectAll = true;
        }

        if (!$this->selectAll) {
            // Deselect all items
            $this->itemSelected = [];
            $this->selectAll = false;
            $this->countSelected = 0;
        } else {
            // Select all items
            $this->itemSelected = $this->activeListings->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->activeListings->count();

            $this->itemSelected = $this->itemSelected->toArray();
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

        $this->alert('success', 'Data berhasil di hapus!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
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
        return view('pica::livewire.listing.return-document.return-document-page')->layout('pica::layouts.app');
    }
}
