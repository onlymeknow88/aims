<?php

namespace Modules\FieldLeadership\Http\Livewire\Dashboard\Partials;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Exports\FieldLeadershipExport;
use App\Models\AreaLocation;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;

class TableMaker extends Component
{
    use WithPagination;

    public $year;

    public $limit;

    public $countData;

    public $itemSelected = [];

    public $countSelected = 0;

    public $info = false;

    public $columns = ['Date', 'CCOW', 'Company', 'Detail Company', 'Department', 'Section', 'Location', 'Detail Location', 'Type', 'Members', 'Positive Condition', 'Risk Condition', 'Repair Action', 'Status'];

    public $selectedColumns = [];

    public $search;

    public $latestUpdate;

    public $sortType = 'desc';

    public $sortField = 'created_at';

    public $sortSelected = [];

    public $sortFieldSelected;

    public $fieldCompany;

    public $searchCompany;

    public $fieldCcow;

    public $searchCcow;

    public $fieldDetailCompany;

    public $searchDetailCompany;

    public $fieldDepartment;

    public $searchDepartment;

    public $fieldSection;

    public $searchSection;

    public $fieldLocation;

    public $searchLocation;

    public $fieldDetailLocation;

    public $searchDetailLocation;

    public $fieldType;

    public $searchType;

    public $fieldMember;

    public $searchMember;

    public $fieldPositive;

    public $searchPositive;

    public $fieldRiskCondition;

    public $searchRiskCondition;

    public $fieldCategory;

    public $searchCategory;

    public $fieldRepairAction;

    public $searchRepairAction;

    public $fieldPotency;

    public $searchPotency;

    public $fieldPja;

    public $searchPja;

    public $findMaker;

    public $superUser;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        // auth()->user()->hasPermissionTo('Field Leadsership - View Request Review For PJA')
        $this->selectedColumns = $this->columns;

        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on '.Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldDetailCompany = FieldLeadership::where('published', FieldLeadershipType::Publish)->get()->groupBy('detail_company')->toBase();
        $this->fieldCompany = Company::all();
        $this->fieldCcow = Company::where('type', CompanyType::Internal)->get();
        $this->fieldDepartment = Department::all();
        $this->fieldSection = Section::all();
        $this->fieldLocation = AreaLocation::all();
        $this->fieldType = ['Planned Task Observation', 'Take Time Talk', 'Hazard Report'];
        $this->fieldCategory = FieldLeadershipCategory::all();
        $this->fieldPotency = FieldLeadershipPotencyAndConsequnce::all();

        $this->countData = FieldLeadership::when(! empty($this->year), function ($query) {
            $query->whereYear('created_at', $this->year);
        })
            ->where('published', FieldLeadershipType::Publish)
            ->get()
            ->count();

        $this->limit = $this->countData;

        $this->findMaker = FieldLeadership::where('created_by', auth()->user()->employee?->id)->get()->count();
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

        if (! empty($this->sortSelected[$this->sortFieldSelected])) {
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

        // dd($this->sortSelected);
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

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        try {
            return FieldLeadership::when(! empty($this->year), function ($query) {
                $query->whereYear('created_at', $this->year);
            })
                ->where('published', FieldLeadershipType::Publish)
                ->orderBy($this->sortField, $this->sortType)
                ->paginate($this->limit);
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => 'Error | '.$err,
            ]);
        }
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            // array_merge($this->itemSelected, array($this->itemSelected[$key]));
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            // /array_push($this->itemSelected, $id);
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = ! $this->info;
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

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data berhasil di hapus',
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
        return view('fieldleadership::livewire.dashboard.partials.table-maker')->layout('fieldleadership::layouts.app');
    }
}
