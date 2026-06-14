<?php

namespace Modules\DocumentSystem\Http\Livewire\Obsolate;

use App\Exports\DocumentSystemExport;
use App\Models\Company;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Module;
use App\Models\User;
use App\Services\EmailService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\DocumentSystem\Entities\Category;
use Modules\DocumentSystem\Entities\Mapping;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $countSelected;
    public $itemSelected = [];
    public $countData = 0;
    public $latestUpdate;
    public $limit = 0;
    public $selectAll = false;

    public $columns = ['Company', 'Department', 'PIC', 'Modul', 'Category', 'Document Type', 'Mapping', 'Title Document', 'ID Document', 'Revisi No.', 'Date of Created', 'Attachment', 'Status'];
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
    public $fieldCategory;
    public $fieldMapping;

    public $searchTitle;
    public $searchIdDocument;
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

        // $this->availableData();
        $status = Document::availableStatus();
        $statuses = [];
        foreach ($status as $key => $s) {
            $statuses[] = [
                'id' => $key,
                'name' => $s,
            ];
        }

        $last = Document::select('id')->orderBy('updated_at', 'desc')->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCompany = Company::select('companies.id', 'companies.company_name')
            ->join('departments', 'companies.id', '=', 'departments.company_id')
            ->join('document_system_documents', 'departments.id', '=', 'document_system_documents.department_id')
            ->where('document_system_documents.status', Document::OBSOLATE)
            ->groupBy('companies.id', 'companies.company_name')
            ->get();

        $this->fieldDepartment = Document::where('status', Document::OBSOLATE)
            ->get()
            ->groupBy('department_id')
            ->map(function ($item) {
                return $item->first()->department;
            });

        $documentTypes = [
            Document::SOP_DOC_TYPE => trans('global.sop'),
            Document::TS_DOC_TYPE => trans('global.ts'),
            Document::MN_DOC_TYPE => trans('global.manual'),
            Document::WIN_DOC_TYPE => 'Working Instruction',
            Document::FORM_DOC_TYPE => 'Form',
        ];

        $this->fieldDocumentTypes = Document::where('status', Document::OBSOLATE)
            ->whereIn('document_level', array_keys($documentTypes))
            ->get()
            ->groupBy('document_level')
            ->map(function ($item) {
                return $item->first()->documenttype;
            });

        $this->fieldModule  = Module::select('document_system_modules.id', 'document_system_modules.name')
            ->join('document_system_categories', 'document_system_modules.id', '=', 'document_system_categories.module_id')
            ->join('document_system_mappings', 'document_system_categories.id', '=', 'document_system_mappings.category_id')
            ->join('document_system_documents', 'document_system_mappings.id', '=', 'document_system_documents.mapping_id')
            ->where('document_system_documents.status', Document::OBSOLATE)
            ->groupBy('document_system_modules.id', 'document_system_modules.name')
            ->get();

        $this->fieldCategory  = Category::select('document_system_categories.id', 'document_system_categories.name')
            ->join('document_system_mappings', 'document_system_categories.id', '=', 'document_system_mappings.category_id')
            ->join('document_system_documents', 'document_system_mappings.id', '=', 'document_system_documents.mapping_id')
            ->where('document_system_documents.status', Document::ACTIVE)
            ->groupBy('document_system_categories.id', 'document_system_categories.name')
            ->get();


        $this->fieldMapping  = Mapping::select('document_system_mappings.id', 'document_system_mappings.name')
            ->join('document_system_documents', 'document_system_mappings.id', '=', 'document_system_documents.mapping_id')
            ->where('document_system_documents.status', Document::ACTIVE)
            ->groupBy('document_system_mappings.id', 'document_system_mappings.name')
            ->get();

        $this->countData = $this->getListingsProperty()->total();
        $this->limit = $this->countData;
    }

    // BEGIN::FILTER
    public function removeItemFilter($field)
    {
        if ($field == 'title') {
            $this->searchTitle = null;
        }

        if ($field == 'id_document') {
            $this->searchIdDocument = null;
        }

        if ($field == 'revision') {
            $this->sortField = null;
        }

        if ($field == 'pic') {
            $this->searchPic = null;
        }

        if ($field == 'company_id') {
            // $this->sortField = null;
            unset($this->sortSelected['company_id']);
        }

        if ($field == 'department_id') {
            // $this->sortField = null;
            unset($this->sortSelected['department_id']);
        }

        if ($field == 'document_level') {
            // $this->sortField = null;
            unset($this->sortSelected['document_level']);
        }

        if ($field == 'module_id') {
            // $this->sortField = null;
            unset($this->sortSelected['module_id']);
        }

        if ($field == 'category_id') {
            // $this->sortField = null;
            unset($this->sortSelected['category_id']);
        }

        if ($field == 'mapping_id') {
            // $this->sortField = null;
            unset($this->sortSelected['mapping_id']);
        }

        if ($field == 'date') {
            $this->startDate = null;
            $this->endDate = null;
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

    public function getListingsProperty(): LengthAwarePaginator
    {
        try {
            return Document::with(['attachments' => fn($q) => $q->where('status', 1), 'department.company', 'user', 'mapping.category.module'])
                ->when(!empty($this->sortSelected), function ($q) {
                $q->where(function ($q) {
                    $q->when(isset($this->sortSelected['company_id']), function ($q) {
                        $q->whereHas('department', function ($q) {
                            $q->whereIn('company_id', $this->sortSelected['company_id']);
                        });
                    });
                    $q->when(isset($this->sortSelected['department_id']), function ($q) {
                        $q->whereIn('department_id', $this->sortSelected['department_id']);
                    });
                    $q->when(isset($this->sortSelected['document_level']), function ($q) {
                        $q->whereIn('document_level', $this->sortSelected['document_level']);
                    });
                    $q->when(isset($this->sortSelected['module_id']), function ($q) {
                        $q->whereIn('module_id', $this->sortSelected['module_id']);
                    });
                });
            })
                ->when(!empty($this->searchTitle), function ($query) {
                    $query->where('title', 'like', '%' . $this->searchTitle . '%');
                })
                ->when(!empty($this->searchIdDocument), function ($query) {
                    $query->where('sop_number', 'like', '%' . $this->searchIdDocument . '%')
                        ->orWhere('sop_add_win', 'like', '%' . $this->searchIdDocument . '%')
                        ->orWhere('sop_add_form', 'like', '%' . $this->searchIdDocument . '%')
                        ->orWhere('document_number', 'like', '%' . $this->searchIdDocument . '%')
                        ->orWhere('prefix_code', 'like', '%' . $this->searchIdDocument . '%');
                })
                ->when(!empty($this->searchPic), function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->searchPic . '%');
                    });
                })
                ->when(optional(auth()->user()->company)->type == 'INTERNAL', function ($q) {
                    $q->whereIn('upload_type', ['document', 'record']);
                }, function ($q) {
                    $q->where('upload_type', 'document');
                })
                ->when(!empty($this->search), function ($query) {
                    $query->search($this->search);
                })
                // ->orWhere('user_id', auth()->user()->id)
                ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                    $query->whereBetween('doc_created', [$this->startDate, $this->endDate]);
                })
                // ->where('created_by', auth()->user()->id)
                ->when(
                    !auth()->user()->hasAnyPermission([
                        'Document System - Approve Document Level 1',
                        'Document System - Approve Document Level 2',
                    ]),
                    function ($q) {
                        $q->where('created_by', auth()->user()->id);
                    }
                )
                ->where('status', Document::OBSOLATE)
                ->orderBy($this->sortField, $this->sortType)
                ->paginate($this->limit);
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);

            // Return an empty paginator to satisfy the return type
            return Document::whereRaw('1 = 0')->paginate($this->limit);
        }
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

    /**
     * Function to select all items
     */

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

    public function activedInfo()
    {
        $this->info = !$this->info;
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
                $data = Document::find($ids[$a]);
                if ($data->status == Document::ACTIVE) {
                    DB::rollBack();

                    $this->flash('error', trans('global.failed_delete_active_document'), [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);

                    return redirect()->route('document-systems::document-systems.obsolate');
                }

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
            return redirect()->route('document-systems::document-systems.obsolate');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to delete document',
            ]);
        }
    }

    public function render()
    {
        return view('documentsystem::livewire.obsolate.index')->layout('documentsystem::layouts.app');
    }
}
