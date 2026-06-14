<?php

namespace Modules\KPP\Http\Livewire\Rule;

use App\Enums\KPP\ObedienceStatus;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KPP\Entities\KppAgencyAuthority;
use Modules\KPP\Entities\KppObedience;
use Modules\KPP\Entities\KppObedienceEmail;
use Modules\KPP\Entities\KppObedienceRequest;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Entities\KppRuleType;
use Modules\KPP\Exports\RuleExport;
use Modules\KPP\Jobs\NewObedienceNotificationJob;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Active extends Component
{
    use WithPagination, LivewireAlert;

    public $limit;
    public $countData;
    public $selectAll = false;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $comment = '';

    public $companies;

    public $company_ids = [];

    public $invitedPeople = [];
    public $inputInvited = '';

    public $notify_to = 'none';
    public $columns = ['Nomor Peraturan', 'Judul Peraturan', 'Jenis Peraturan', 'Otoritas Instansi', 'Status', 'Document Type', 'Kepatuhan', 'Total Ekstraksi'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $sortType = 'desc';
    public $sortField = 'created_at';
    public $sortSelected = [];
    public $sortFieldSelected;
    public $searchNumber;
    public $searchTitle;
    public $fieldType;
    public $fieldAgencyAuthority;
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount()
    {
        $this->companies = Company::all();

        $this->selectedColumns = $this->columns;

        $last = KppRule::where('is_draft', 0)->whereNot('status', 'Dicabut')->latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        //column search
        $this->fieldType = KppRuleType::all();
        $this->fieldAgencyAuthority = KppAgencyAuthority::all();

        $this->countData = KppRule::where('is_draft', 0)->whereNot('status', 'Dicabut')->get()->count();
        $this->limit = $this->countData;
    }

    public function removeItemFilter($field)
    {
        if ($field == 'rule_type_id') {
            unset($this->sortSelected['rule_type_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'agency_authority_id') {
            unset($this->sortSelected['agency_authority_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'status') {
            unset($this->sortSelected['status']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'document_type') {
            unset($this->sortSelected['document_type']);
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
    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }
    // END::SEARCH

    // BEGIN::COLUMN
    public function searchUpdated($search)
    {
        $this->search = $search;
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

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    public function getRulesProperty(): LengthAwarePaginator
    {
        DB::statement("SET SQL_MODE=''");
        return KppRule::where('is_draft', 0)->whereNot('status', 'Dicabut')
            ->when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query
                        ->when(isset($this->sortSelected['agency_authority_id']), function ($query) {
                            $query->whereIn('agency_authority_id', $this->sortSelected['agency_authority_id']);
                        })
                        ->when(isset($this->sortSelected['rule_type_id']), function ($query) {
                            $query->whereIn('rule_type_id', $this->sortSelected['rule_type_id']);
                        })
                        ->when(isset($this->sortSelected['status']), function ($query) {
                            $query->whereIn('status', $this->sortSelected['status']);
                        })
                        ->when(isset($this->sortSelected['document_type']), function ($query) {
                            $query->whereIn('document_type', $this->sortSelected['document_type']);
                        });
                });
            })
            ->when(!empty($this->searchNumber), function ($query) {
                $query->where('number', 'like', '%' . $this->searchNumber . '%');
            })
            ->when(!empty($this->searchTitle), function ($query) {
                $query->where('title', 'like', '%' . $this->searchTitle . '%');
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
            $this->itemSelected = $this->rules->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->rules->count();

            $this->itemSelected = $this->itemSelected->toArray();
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
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
        try {
            DB::beginTransaction();
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

            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('kpp::rules.index');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function storeObedience()
    {
        try {
            DB::beginTransaction();

            foreach ($this->itemSelected as $item) {
                $rule = KppRule::find($item);

                foreach ($this->company_ids as $company_id) {
                    $obedience = KppObedience::where('company_id', $company_id)
                        ->where('rule_id', $rule->id)
                        ->first();

                    if (!$obedience) {
                        $obedience = KppObedience::create([
                            'rule_id' => $rule->id,
                            'status' => ObedienceStatus::Draft()->value,
                            'company_id' => $company_id,
                            'comment' => $this->comment
                        ]);

                        foreach ($this->invitedPeople as $email) {
                            KppObedienceEmail::create([
                                'obedience_id' => $obedience->id,
                                'email' => $email
                            ]);
                        }

                        $user_emails = [];
                        if ($this->notify_to == 'user') {
                            $user_emails = $this->invitedPeople;
                        } elseif ($this->notify_to == 'company') {
                            $company = Company::find($company_id);

                            NewObedienceNotificationJob::dispatch('company', $company->email, $obedience);
                        } elseif ($this->notify_to == 'both') {
                            $user_emails = $this->invitedPeople;
                            $company = Company::find($company_id);
                            NewObedienceNotificationJob::dispatch('company', $company->email, $obedience);
                        }
                    }
                }

                if (!empty($user_emails)) {
                    NewObedienceNotificationJob::dispatch('user', $user_emails, $rule);
                }
            }


            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('kpp::rules.index');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function exportExcel()
    {
        $now = Carbon::now()->toDateTimeString();
        return Excel::download(new RuleExport($this->itemSelected), "rules_$now.xlsx");
    }

    public function render()
    {
        return view('kpp::livewire.rule.active')
            ->layout('kpp::layouts.app');
    }
}
