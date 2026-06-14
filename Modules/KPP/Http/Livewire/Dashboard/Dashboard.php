<?php

namespace Modules\KPP\Http\Livewire\Dashboard;

use App\Enums\CompanyType;
use App\Enums\KPP\ExtractionStatus;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KPP\Entities\KppAgencyAuthority;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppObedience;
use Modules\KPP\Entities\KppObedienceEmail;
use Modules\KPP\Entities\KppObedienceRequest;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Entities\KppRuleType;
use Modules\KPP\Exports\RuleExport;
use Modules\KPP\Jobs\NewObedienceNotificationJob;

class Dashboard extends Component
{
    use WithPagination;

    public $limit;
    public $countData;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $comment = '';

    public $internals = [];
    public $contractors = [];
    public $subContractors = [];

    public $internal = '';
    public $contractor = '';
    public $subContractor = '';

    public $invitedPeople = [];
    public $inputInvited = '';

    public $document_type = '';

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public $columns = ['Nomor Peraturan', 'Judul Peraturan', 'Jenis Peraturan', 'Kepatuhan', 'Total Ekstraksi', 'Total Pasal', 'Status Kepatuhan', 'Level Kepatuhan'];
    //'Agency Authority', 'Status', 'Kepatuhan'
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $searchNumber;
    public $fieldType;
    public $fieldAgencyAuthority;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount(Request $request)
    {
        if ($request->has('document_type')) {
            $this->document_type = $request->document_type;
        }

        $this->internals = Company::where('type', CompanyType::Internal()->value)->get();

        $this->selectedColumns = $this->columns;

        //$last = KppRule::where('is_draft', 0)->latest()->whereNot('status', 'Tidak Berlaku')->first();
        //$this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        //column search
        $this->fieldType = KppRuleType::all();
        $this->fieldAgencyAuthority = KppAgencyAuthority::all();

        $this->countData = KppRule::where('is_draft', 0)->get()->count();
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

        $this->dispatchBrowserEvent('refreshChart');
    }
    // END::COLUMN

    public function getRulesProperty(): LengthAwarePaginator
    {
        DB::statement("SET SQL_MODE=''");
        return KppRule::where('is_draft', 0)
            //->whereNot('status', 'Tidak Berlaku')
            ->when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when($this->sortFieldSelected == 'rule_type_id', function ($query) {
                        $query->whereIn('rule_type_id', $this->sortSelected['rule_type_id']);
                    })
                    ->when($this->sortFieldSelected == 'agency_authority_id', function ($query) {
                        $query->whereIn('agency_authority_id', $this->sortSelected['agency_authority_id']);
                    })
                    ->when($this->sortFieldSelected == 'status', function ($query) {
                        $query->whereIn('status', $this->sortSelected['status']);
                    });
                });
            })
            ->when(!empty($this->searchNumber), function ($query) {
                $query->where('number', 'like', '%' . $this->searchNumber . '%');
            })
            ->when(!empty($this->document_type != ''), function ($query) {
                $query->where('document_type', $this->document_type);
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortType)
            ->latest()
            ->paginate($this->limit);
    }

    public function getCompanySummaryProperty()
    {
        $companies = Company::where('type', CompanyType::Internal()->value)->get();

        foreach ($companies as $key => $company) {
            $obedience_ids = KppObedience::where('company_id', $company->id)->pluck('id');

            $companies[$key]->total_extraction = KppExtraction::whereIn('obedience_id', $obedience_ids)->count();
            $companies[$key]->patuh = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Patuh')->count();
            $companies[$key]->tidak_patuh = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Tidak Patuh')->count();
            $companies[$key]->tidak_berlaku = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Tidak Berlaku')->count();
            $companies[$key]->in_progress = KppExtraction::whereIn('obedience_id', $obedience_ids)->whereIn('status', ['Draft','Checking','In Review'])->get()->count();
        }

        return $companies;
    }

    public function getCompliedTotalProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::Complied()->value)
        ->count();
    }

    public function getPeraturanCompliedProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::Complied()->value)
        ->whereNot('compliance_level', 'IA')
        ->count();
    }

    public function getPerizinanCompliedProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::Complied()->value)
        ->where('compliance_level', 'IA')
        ->count();
    }

    public function getNotComplyTotalProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotComply()->value)
        ->count();
    }

    public function getPeraturanNotComplyProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotComply()->value)
        ->whereNot('compliance_level', 'IA')
        ->count();
    }

    public function getPerizinanNotComplyProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotComply()->value)
        ->where('compliance_level', 'IA')
        ->count();
    }

    public function getNotApplicableTotalProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotApplicable()->value)
        ->count();
    }

    public function getPeraturanNotApplicableProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotApplicable()->value)
        ->whereNot('compliance_level', 'IA')
        ->count();
    }

    public function getPerizinanNotApplicableProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotApplicable()->value)
        ->where('compliance_level', 'IA')
        ->count();
    }

    public function getInProgressTotalProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->whereIn('status', [ExtractionStatus::Checking()->value, ExtractionStatus::InReview()->value, ExtractionStatus::UnderRevision()->value])
        ->count();
    }

    public function getPeraturanInProgressProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->whereIn('status', [ExtractionStatus::Checking()->value, ExtractionStatus::InReview()->value, ExtractionStatus::UnderRevision()->value])
        ->whereNot('compliance_level', 'IA')
        ->count();
    }

    public function getPerizinanInProgressProperty()
    {
        return KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->whereIn('status', [ExtractionStatus::Checking()->value, ExtractionStatus::InReview()->value, ExtractionStatus::UnderRevision()->value])
        ->where('compliance_level', 'IA')
        ->count();
    }

    public function getExtractionTotalProperty()
    {
        $extractions = KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->whereNot('status', ExtractionStatus::Draft()->value)
        ->count();

        return $extractions > 0 ? $extractions : 1;
    }

    public function getCompliedChartProperty()
    {
        $extractions = KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::Complied()->value)
        ->select('compliance_level', DB::raw('count(*) as total'))
        ->groupBy('compliance_level')
        ->get();

        $chart = [
            'idChart' => 'complied',
            'width' => 300,
            'height' => 300,
            'labels' => $extractions->pluck('compliance_level')->toArray(),
            'datasets' => [[
                'label' => 'Complied',
                'data' => $extractions->pluck('total')->toArray(),
                // 'backgroundColor' => [
                //     'rgb(255, 99, 132)',
                //     'rgb(54, 162, 235)',
                //     'rgb(255, 205, 86)',
                //     'rgb(255, 99, 132)',
                //     'rgb(54, 162, 235)',
                // ],
            ]],
            'legend' => true,
            'labelX' => [
                'display' => false,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];

        return $chart;
    }

    public function getNotComplyChartProperty()
    {
        $extractions = KppExtraction::whereHas('obedience', function ($query) {
            $query->whereIn('rule_id', $this->rules->pluck('id'));
        })
        ->where('status', ExtractionStatus::NotComply()->value)
        ->select('compliance_level', DB::raw('count(*) as total'))
        ->groupBy('compliance_level')
        ->get();

        $chart = [
            'idChart' => 'notComply',
            'width' => 300,
            'height' => 300,
            'labels' => $extractions->pluck('compliance_level')->toArray(),
            'datasets' => [[
                'label' => 'Not Comply',
                'data' => $extractions->pluck('total')->toArray(),
                // 'backgroundColor' => [
                //     'rgb(255, 99, 132)',
                //     'rgb(54, 162, 235)',
                //     'rgb(255, 205, 86)',
                //     'rgb(255, 99, 132)',
                //     'rgb(54, 162, 235)',
                // ],
            ]],
            'legend' => true,
            'labelX' => [
                'display' => false,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];

        return $chart;
    }

    public function updatedInternal()
    {
        $this->contractors = Company::where('type', CompanyType::Contractor()->value)
            ->where('parent_company_id', $this->internal)
            ->get();
        // $this->dispatchBrowserEvent('refresh');
    }

    public function updatedContractor()
    {
        $this->subContractors = Company::where('type', CompanyType::SubContractor()->value)
            ->where('parent_company_id', $this->contractor)
            ->get();
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

    public function addInvitedPeople()
    {
        if (in_array($this->inputInvited, $this->invitedPeople)) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon' => 'success',
                'text' => 'Email sudah ada'
            ]);
        } else {
            $this->invitedPeople[] = $this->inputInvited;
            $this->inputInvited = '';
        }
    }

    public function removeInvited($email)
    {
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);
    }

    public function requestObedience()
    {
        foreach ($this->itemSelected as $item) {
            $existObedience = KppObedience::where('company_id', Auth::user()->department->company_id)
                ->where('rule_id', $item)
                ->first();

            if (!$existObedience) {
                KppObedienceRequest::create([
                    'company_id' => Auth::user()->department->company_id,
                    'rule_id' => $item,
                    'status' => 'Requested',
                    'comment' => $this->comment,
                    'requested_by' => Auth::user()->id
                ]);
            }
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            //'text' => 'Request Kepatuhan Berhasil'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
        $this->comment = '';

        $this->dispatchBrowserEvent('closeModal');
    }

    public function storeObedience()
    {
        $emails = $this->invitedPeople;

        if ($this->subContractor != '') {
            $company = $this->subContractor;
        } elseif ($this->contractor != '') {
            $company = $this->contractor;
        } else {
            $company = $this->internal;
        }

        foreach ($this->itemSelected as $item) {
            $rule = KppRule::find($item);

            // foreach ($companies as $company) {
                $obedience = KppObedience::where('company_id', $company)
                    ->where('rule_id', $rule->id)
                    ->first();

                if (!$obedience) {
                    $obedience = KppObedience::create([
                        'rule_id' => $rule->id,
                        'status' => 'Belum Ekstraksi',
                        'company_id' => $company,
                        'comment' => $this->comment
                    ]);

                    foreach ($emails as $email) {
                        KppObedienceEmail::create([
                            'obedience_id' => $obedience->id,
                            'email' => $email
                        ]);
                    }
                }
            // }
        }

        $notify_emails = [];
        if ($this->notify_to == 'user') {
            $notify_emails = $emails;
        } elseif ($this->notify_to == 'company') {
            $department_ids = Department::where('company_id', $company)->pluck('id');
            $notify_emails = User::whereIn('department_id', $department_ids)->pluck('email');
        } elseif ($this->notify_to == 'both') {
            $department_ids = Department::where('company_id', $company)->pluck('id');
            $company_emails = User::whereIn('department_id', $department_ids)->pluck('email')->toArray();
            $notify_emails = array_merge($company_emails, $emails);
        }

        if (!empty($notify_emails)) {
            NewObedienceNotificationJob::dispatch($notify_emails);
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Berhasil Menyimpan Kepatuhan'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
        $this->comment = '';

        $this->dispatchBrowserEvent('closeModal');
    }

    public function exportExcel()
    {
        $now = Carbon::now()->toDateTimeString();
        return Excel::download(new RuleExport($this->itemSelected), "rules_$now.xlsx");
    }

    public function render()
    {
        return view('kpp::livewire.dashboard.dashboard')
            ->layout('kpp::layouts.app');
    }
}
