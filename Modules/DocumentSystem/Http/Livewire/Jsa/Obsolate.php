<?php

namespace Modules\DocumentSystem\Http\Livewire\Jsa;

use App\Models\Company;
use AModules\DocumentSystem\Entities\Document;
use AModules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Entities\JsaDocument;
use App\Models\User;
use Modules\DocumentSystem\Services\JsaService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Traits\WithPagination;

class Obsolate extends Component
{
    use WithPagination;

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

    public $columns = ['Company', 'Department', 'PIC', 'Title', 'ID Document', 'Revisi No.', 'Detail Location', 'Date Created', 'Attachment', 'Status'];
    public $selectedColumns = [];
    public $sortSelected = [];
    public $sortFieldSelected;
    public $sortType = 'desc';
    public $sortField = 'updated_at';

    public $search;
    public $fieldCompany;
    public $fieldDepartment;
    public $fieldDocumentTypes;
    public $fieldModule;

    public $searchTitle;
    public $searchIdDocument;
    public $searchDetailLocation;
    public $searchPic;

    public $startDate, $endDate;

    protected $listeners = [
        'submitDelete',
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = JsaDocument::select('id')->orderBy('updated_at', 'desc')->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::select('companies.id', 'companies.company_name')
            ->join('departments', 'companies.id', '=', 'departments.company_id')
            ->join('jsa_documents', 'departments.id', '=', 'jsa_documents.department_id')
            ->whereIn('jsa_documents.status', [JsaDocument::OBSOLATE])
            ->groupBy('companies.id', 'companies.company_name')
            ->get();

        $this->fieldDepartment = JsaDocument::whereIn('status', [JsaDocument::OBSOLATE])
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

        if ($field == 'revision') {
            $this->sortField = 'updated_at';
            $this->sortType = 'desc';
        }
    }
    // END::FILTER

    public function getListingsProperty(): LengthAwarePaginator
    {
        try {
            return JsaDocument::when(!empty($this->sortSelected), function ($q) {
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
                    $q->where('status', JsaDocument::OBSOLATE);
                })
                ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                    $start = Carbon::parse($this->startDate)->format('Y-m-d');
                    $end = Carbon::parse($this->endDate)->format('Y-m-d');

                    $query->whereBetween('doc_created', [$start, $end]);
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
        $service = new JsaService();
        return $service->export($this->itemSelected, 'obsolate');
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('documentsystem::livewire.jsa.obsolate')->layout('documentsystem::layouts.app');
    }
}
