<?php

namespace Modules\KO\Http\Livewire\Ko\Completed;

use App\Enums\CompanyType;
use Auth;
use App\Enums\KO\KoStatus;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KO\Entities\KoUnit as UnitModel;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KoCompleted extends Component
{
    public $limit;
    public $countData;

    public $itemSelected = [];
    public $countSelected = 0;
    public $selectAll = false;

    public $columns = ['Number', 'CCOW', 'Perusahaan', 'Kriteria Perusahaan', 'Area', 'Waktu Komisioning', 'Jadwal Komisioning', 'Komisioning Selanjutnya', 'Periode', 'SPIP Desc', 'Call Sign', 'Status'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $searchNumber;

    public $fieldCcow;
    public $fieldCompany;
    public $fieldArea;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount(): void
    {
        $this->selectedColumns = $this->columns;

        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        //column search
        $this->fieldCcow = Company::where('type', CompanyType::Internal()->value)->get();
        $this->fieldCompany = Company::all();
        $this->fieldArea = ['Lampunut', 'Haju', 'Tuhup'];

        $this->countData = $this->getKoProposalsProperty()->count();
        $this->limit = $this->countData;
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

    public function getKoProposalsProperty(): LengthAwarePaginator
    {
        DB::statement("SET SQL_MODE=''");
        return KoProposal::query()
            ->where('status', KoStatus::Completed()->value)
            ->where(function ($query) {
                $query->where('ccow_id', Auth::user()->department->company->id)
                    ->orWhere('company_id', Auth::user()->department->company->id);
            })
            ->whereNot('status', KoStatus::Draft()->value)
            ->when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when($this->sortFieldSelected == 'company_id', function ($query) {
                        $query->whereIn('company_id', $this->sortSelected['company_id']);
                    })
                        ->when($this->sortFieldSelected == 'area', function ($query) {
                            $query->whereIn('area', $this->sortSelected['area']);
                        })
                        ->when($this->sortFieldSelected == 'ccow_id', function ($query) {
                            $query->whereIn('ccow_id', $this->sortSelected['ccow_id']);
                        });
                });
            })
            ->when(!empty($this->searchNumber), function ($query) {
                $query->where('number', 'like', '%' . $this->searchNumber . '%');
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
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
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
            $this->itemSelected = $this->koProposals->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->koProposals->count();

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

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function generateQR()
    {
        $proposals = KoProposal::whereIn('id', $this->itemSelected)->get();

        $customPaper = array(0,0,385.00,272.75);

        $pdfContent = PDF::loadView('ko::livewire.ko.qr-export', ['proposals' => $proposals])->setPaper($customPaper, 'landscape')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "commissioning.pdf"
        );
    }

    public function render()
    {
        return view('ko::livewire.ko.completed.ko-completed')->layout('ko::layouts.app');
    }
}
