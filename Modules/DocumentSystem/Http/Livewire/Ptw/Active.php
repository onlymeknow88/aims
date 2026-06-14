<?php

namespace Modules\DocumentSystem\Http\Livewire\Ptw;

use App\Models\Company;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\PtwDocument;
use App\Models\User;
use Modules\DocumentSystem\Services\JsaService;
use Modules\DocumentSystem\Services\PtwService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Traits\WithPagination;

class Active extends Component
{
    use WithPagination, LivewireAlert;

    public int $countSelected = 0;
    public array $availableCompany = [];
    public array $availableDepartment = [];
    public array $availablePics = [];
    public $itemSelected = [];
    public int $countData = 0;
    public int $limit = 0;
    public bool $start_searching = false;
    public $latestUpdate;
    public $selectAll = false;

    public $columns = ['Company', 'Department', 'PIC', 'Title', 'ID Document', 'Detail Location', 'Active At', 'Inactive At', 'Attachment', 'Status'];
    public $selectedColumns = [];
    public $sortSelected = [];
    public $sortFieldSelected;
    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $search;
    public $fieldCompany;
    public $fieldDepartment;
    public $fieldDocumentTypes;
    public $fieldModule;

    public $searchTitle;
    public $searchIdDocument;
    public $searchPic;

    public $startDate, $endDate;
    public $startInactiveDate, $endInactiveDate;

    protected $listeners = [
        'submitDelete',
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;


        $last = PtwDocument::select('id')->orderBy('updated_at', 'desc')->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::select('companies.id', 'companies.company_name')
            ->join('departments', 'companies.id', '=', 'departments.company_id')
            ->join('ptw_documents', 'departments.id', '=', 'ptw_documents.department_id')
            ->whereIn('ptw_documents.status', [PtwDocument::ACTIVE, PtwDocument::INACTIVE])
            ->groupBy('companies.id', 'companies.company_name')
            ->get();

        $this->fieldDepartment = PtwDocument::whereIn('status', [PtwDocument::ACTIVE, PtwDocument::INACTIVE])
            ->get()
            ->groupBy('department_id')
            ->map(function ($item) {
                return $item->first()->department;
            });

        $this->countData = $this->getListingsProperty()->total();
        $this->limit = $this->countData;
    }

    // BEGIN::FILTER
    public function removeItemFilter($field)
    {
        if ($field == 'company_id') {
            unset($this->sortSelected['company_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'department_id') {
            unset($this->sortSelected['department_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'title') {
            $this->searchTitle = null;
        }

        if ($field == 'id_document') {
            $this->searchIdDocument = null;
        }

        if ($field == 'detail_location') {
            $this->searchDetailLocation = null;
        }

        if ($field == 'pic') {
            $this->searchPic = null;
        }

        if ($field == 'active_at' || $field == 'inactive_at') {
            $this->sortField = 'updated_at';
            $this->sortType = 'desc';
        }
    }
    // END::FILTER

    public function getListingsProperty(): LengthAwarePaginator
    {
        try {
            return PtwDocument::when(!empty($this->sortSelected), function ($q) {
                $q->where(function ($q) {
                    $q->when(isset($this->sortSelected['company_id']), function ($q) {
                        $q->whereHas('department', function ($q) {
                            $q->whereIn('company_id', $this->sortSelected['company_id']);
                        });
                    });
                    $q->when(isset($this->sortSelected['department_id']), function ($q) {
                        $q->whereIn('department_id', $this->sortSelected['department_id']);
                    });
                });
            })
                ->when(!empty($this->searchTitle), function ($query) {
                    $query->where('title', 'like', '%' . $this->searchTitle . '%');
                })
                ->when(!empty($this->searchIdDocument), function ($query) {
                    $query->where('document_number', 'like', '%' . $this->searchIdDocument . '%');
                })
                ->when(!empty($this->searchDetailLocation), function ($query) {
                    $query->where('detail_location', 'like', '%' . $this->searchDetailLocation . '%');
                })
                ->when(!empty($this->searchPic), function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->searchPic . '%');
                    });
                })
                ->when(!empty($this->search), function ($query) {
                    $query->search($this->search);
                })
                ->where(function ($q) {
                    $q->where('status', PtwDocument::ACTIVE)
                        ->orWhere('status', PtwDocument::INACTIVE);
                })
                ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                    $start = Carbon::parse($this->startDate)->format('Y-m-d');
                    $end = Carbon::parse($this->endDate)->format('Y-m-d');

                    $query->whereBetween('doc_created', [$start, $end]);
                })
                ->when(!empty($this->startInactiveDate) && !empty($this->endInactiveDate), function ($query) {
                    $start = Carbon::parse($this->startInactiveDate)->format('Y-m-d');
                    $end = Carbon::parse($this->endInactiveDate)->format('Y-m-d');

                    $query->whereBetween('inactive_at', [$start, $end]);
                })
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
            $this->searchTitle = null;
            $this->searchIdDocument = null;
            $this->searchPic = null;
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
            $this->itemSelected = $this->listings->pluck('id')->map(fn($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->listings->count();

            // Ensure itemSelected is an array; handle Collection or array
            if ($this->itemSelected instanceof \Illuminate\Support\Collection) {
                $this->itemSelected = $this->itemSelected->toArray();
            } else {
                $this->itemSelected = (array) $this->itemSelected;
            }
        }
    }

    public function export()
    {
        $service = new PtwService();
        return $service->export($this->itemSelected, 'active');
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    /**
     * Function to show confirmation modal before delete
     */
    public function confirmDelete()
    {
        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => trans('global.confirm_delete'),
            'onConfirmed' => 'submitDelete',
        ]);
        // $this->dispatchBrowserEvent('confirm-delete');
    }

    /**
     * Function to submit delete the selected data
     */
    public function submitDelete()
    {
        DB::beginTransaction();
        try {
            $ids = array_values($this->itemSelected);
            for ($a = 0; $a < count($ids); $a++) {
                $data = PtwDocument::find($ids[$a]);

                $data->delete();
            }
            $this->itemSelected = [];
            $this->countSelected = 0;
            DB::commit();

            $this->flash('success', trans('global.success_delete_document'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-system.ptw.active');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to delete document',
            ]);
        }
    }

    public function render()
    {
        return view('documentsystem::livewire.ptw.active')->layout('documentsystem::layouts.app');
    }
}
