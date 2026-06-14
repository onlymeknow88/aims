<?php

namespace Modules\CSMS\Http\Livewire\PostBidding;

use App\Enums\CSMS\CsmsStatus;
use App\Enums\CompanyType;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\CSMS\Entities\Bidding;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Obsolate extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $limit, $status, $criteria;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $columns = ['CCOW', 'Kriteria', 'Jenis Badan Usaha', 'Nama Perusahaan', 'Alamat Perusahaan', 'Site Perusahaan', 'Nomor Ijin Badan Usaha', 'Perusahaan Induk', 'Nama Penanggung Jawab Bidder', 'Request', 'Status'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $idSelected;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $selectAll = false;
    public $sortSelected = [];
    public $sortFieldSelected;

    public $searchCcow, $searchCompanyBusinessType, $searchCompanyName, $searchCompanyAddress, $searchCompanySites, $searchCompanyBusinessLicenseNumber, $searchCompanyParent, $searchPIC;

    public $findMaker;
    public $superUser;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $b = Bidding::where('maker_id', auth()->user()->id)
            ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal, CsmsStatus::Inactive])
            ->whereIn('status', [CsmsStatus::Obsolate])
            ->where('published', CsmsStatus::Publish);

        $this->countData    = $b->get()->count();
        $this->limit        = $this->countData ? $this->countData : 0;
        $last               = $b->latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->updated_at ?? null)->format('F d, Y . H:i A');
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function sort($type, $field)
    {
        $this->sortType = $type;
        $this->sortField = $field;
    }

    public function sortCheck($field, $value)
    {
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
    }

    public function searchUpdated($search)
    {
        $this->search = $search;
    }

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

    public function filterInspectionType($var, $value)
    {
        if (stripos($var, $value) !== false) {
            return true;
        }

        return false;
    }

    public function getBiddingListingsProperty()
    {
        return Bidding::when(!empty($this->sortSelected), function ($query) {
            $query->where(function ($query) {
                $query->when($this->sortFieldSelected == 'ccow_id', function ($query) {
                    array_key_exists('ccow_id', $this->sortSelected) ? $query->whereIn('ccow_id', $this->sortSelected['ccow_id']) : '';
                });
            });
        })
            ->when(!empty($this->searchCcow), function ($query) {
                $query->whereHas('ccow', function ($query) {
                    $query->where('company_name', 'like', '%' . $this->searchCcow . '%');
                });
            })
            ->where('maker_id', Auth::user()->id)
            ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal, CsmsStatus::Inactive])
            ->whereIn('status', [CsmsStatus::Obsolate])
            ->where('published', CsmsStatus::Publish)

            ->orderByRaw("FIELD(requested , '" . CsmsStatus::Rejected . "','" . CsmsStatus::Approved . "', '" . CsmsStatus::RequestedKTT . "', '" . CsmsStatus::RequestedDHOHS . "', '" . CsmsStatus::RequestedOHS . "') ASC")
            // ->orderBy('date', 'DESC')

            ->orderBy($this->sortField, $this->sortType)
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
            $this->itemSelected = $this->BiddingListings->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->BiddingListings->count();

            $this->itemSelected = $this->itemSelected->toArray();
        }
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $bidding = Bidding::find($item);

            DB::beginTransaction();

            if ($bidding->checklists) {
                foreach ($bidding->checklists as $checklist) {
                    if ($checklist->files) {
                        foreach ($checklist->files as $file) {
                            $file->delete();
                        }
                    }
                    $checklist->delete();
                }
            }

            $bidding->delete();
            DB::commit();
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

    public function render()
    {
        return view('csms::livewire.post-bidding.obsolate')->layout('csms::layouts.app');
    }
}
