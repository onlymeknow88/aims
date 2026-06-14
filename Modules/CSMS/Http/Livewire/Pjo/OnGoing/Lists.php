<?php

namespace Modules\CSMS\Http\Livewire\Pjo\OnGoing;

use App\Enums\CompanyType;
use App\Enums\CSMS\CsmsStatus;
use App\Exports\Csms\PjoExport;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CSMS\Entities\CsmsPjo;

class Lists extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;

    public $limit;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Company', 'Criteria', 'CCOW', 'Submission', 'Number', 'Name', 'Date Of Birth', 'Phone', 'Email', 'Status', 'Published'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $selectAll = false;
    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldCompany, $searchCompany;
    public $fieldCcow, $searchCcow;
    public $searchCriteria;
    public $searchSubmission;
    public $searchNumber;
    public $searchName;
    public $searchPhone;
    public $searchEmail;

    public $startDate, $endDate;


    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $this->latestUpdate = 'Update on ' . Carbon::now()->format('F d, Y . H:i A');

        $this->countData = CsmsPjo::whereNot('status', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish)
            ->count();

        $this->limit = $this->countData;

        $this->fieldCompany = CsmsPjo::whereNot('status', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish)
            // ->where('created_by', auth()->user()->employee->id)
            ->get()
            ->groupBy('company_id')
            ->map(function ($item) {
                return $item->first()->company;
            });

        $this->fieldCcow = CsmsPjo::whereNot('status', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish)
            ->whereHas('ccow', function ($query) {
                $query->whereIn('type', [CompanyType::Contractor, CompanyType::SubContractor]);
            })
            // ->where('created_by', auth()->user()->employee->id)
            ->get()
            ->groupBy('ccow_id')
            ->map(function ($item) {
                return $item->first()->ccow;
            });
    }

    // BEGIN::FILTER
    public function removeItemFilter($field)
    {
        if ($field == 'company_id') {
            $this->searchCompany = null;
            unset($this->sortSelected['company_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'ccow_id') {
            $this->searchCcow = null;
            unset($this->sortSelected['ccow_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'criteria') {
            $this->searchCriteria = null;
        }

        if ($field == 'submission') {
            $this->searchSubmission = null;
        }

        if ($field == 'number_pjo') {
            $this->searchNumber = null;
        }

        if ($field == 'name') {
            $this->searchName = null;
        }

        if ($field == 'phone') {
            $this->searchPhone = null;
        }

        if ($field == 'email') {
            $this->searchEmail = null;
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
        try {
            return CsmsPjo::when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when(isset($this->sortSelected['company_id']), function ($query) {
                        $query->whereIn('company_id', $this->sortSelected['company_id']);
                    })
                        ->when(isset($this->sortSelected['ccow_id']), function ($query) {
                            $query->whereIn('ccow_id', $this->sortSelected['ccow_id']);
                        });
                });
            })
                ->when(!empty($this->searchCompany), function ($query) {
                    $query->whereHas('company', function ($query) {
                        $query->where('company_name', 'like', '%' . $this->searchCompany . '%');
                    });
                })
                ->when(!empty($this->searchCcow), function ($query) {
                    $query->whereHas('ccow', function ($query) {
                        $query->where('company_name', 'like', '%' . $this->searchCcow . '%');
                    });
                })
                ->when(!empty($this->searchCriteria), function ($query) {
                    $query->where('criteria', 'like', '%' . $this->searchCriteria . '%');
                })
                ->when(!empty($this->searchSubmission), function ($query) {
                    $query->where('submission', 'like', '%' . $this->searchSubmission . '%');
                })
                ->when(!empty($this->searchNumber), function ($query) {
                    $query->where('number_pjo', 'like', '%' . $this->searchNumber . '%');
                })
                ->when(!empty($this->searchName), function ($query) {
                    $query->where('name', 'like', '%' . $this->searchName . '%');
                })
                ->when(!empty($this->searchPhone), function ($query) {
                    $query->where('phone', 'like', '%' . $this->searchPhone . '%');
                })
                ->when(!empty($this->searchEmail), function ($query) {
                    $query->where('email', 'like', '%' . $this->searchEmail . '%');
                })
                ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                    $start = Carbon::parse($this->startDate)->format('Y-m-d');
                    $end = Carbon::parse($this->endDate)->format('Y-m-d');

                    $query->whereBetween('date_of_birth', [$start, $end]);
                })
                ->whereNot('status', CsmsStatus::Approved)
                ->where('published', CsmsStatus::Publish)
                ->orderBy($this->sortField, $this->sortType)
                ->paginate($this->limit);
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function exportExcel()
    {
        $now = Carbon::now()->toDateTimeString();
        return Excel::download(new PjoExport($this->itemSelected), "CSMS_PJO_$now.xlsx");
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
            //dd($this->countSelected);
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
        CsmsPjo::whereIn('id', $this->itemSelected)->delete();

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
        return view('csms::livewire.pjo.on-going.lists')->layout('csms::layouts.app');
    }
}
