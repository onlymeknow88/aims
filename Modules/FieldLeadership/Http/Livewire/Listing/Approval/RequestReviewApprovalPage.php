<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Approval;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Exports\FieldLeadershipExport;
use App\Models\AreaLocation;
use App\Models\Company;
use App\Models\Department;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;

class RequestReviewApprovalPage extends Component
{
    use WithPagination, LivewireAlert;

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

    public $selectAll = false;
    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldCompany, $searchCompany;
    public $fieldCcow, $searchCcow;
    public $fieldDetailCompany, $searchDetailCompany;
    public $fieldDepartment, $searchDepartment;
    public $fieldSection, $searchSection;
    public $fieldLocation, $searchLocation;
    public $fieldDetailLocation, $searchDetailLocation;
    public $fieldType, $searchType;
    public $fieldMember, $searchMember;
    public $fieldPositive, $searchPositive;
    public $fieldRiskCondition, $searchRiskCondition;
    public $fieldCategory, $searchCategory;
    public $fieldConditionType, $searchConditionType;
    public $fieldRepairAction, $searchRepairAction;
    public $fieldPotency, $searchPotency;
    public $fieldPja, $searchPja;

    public $startDate, $endDate;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->fieldDetailCompany = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('detail_company')
            ->toBase();
        $this->fieldCompany = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('company_id')
            ->map(function ($item) {
                return $item->first()->company;
            });
        $this->fieldCcow = FieldLeadership::whereHas('ccow', function ($query) {
            $query->where('type', CompanyType::Internal);
        })
            ->where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('ccow_id')
            ->map(function ($item) {
                return $item->first()->ccow;
            });
        $this->fieldDepartment = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('department_id')
            ->map(function ($item) {
                return $item->first()->department;
            });
        $this->fieldSection = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('section_id')
            ->map(function ($item) {
                return $item->first()->section;
            });
        $this->fieldLocation = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('area_location_id')
            ->map(function ($item) {
                return $item->first()->areaLocation;
            });
        $this->fieldType = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->groupBy('type')
            ->toBase();
        $this->fieldCategory = FieldLeadershipRisk::whereNotNull('category_id')
            ->get()
            ->groupBy('category_id')
            ->map(function ($item) {
                return $item->first()->category;
            });
        $this->fieldConditionType = FieldLeadershipRisk::whereHas('fieldLeadership', function ($query) {
            $query->where('created_by', auth()->user()->employee?->id);
        })
            ->whereNotNull('type_id')
            ->get()
            ->groupBy('type_id')
            ->map(function ($item) {
                return $item->first()->type;
            });
        $this->fieldPotency = FieldLeadershipRisk::whereNotNull('potency_id')
            ->get()
            ->groupBy('potency_id')
            ->map(function ($item) {
                return $item->first()->potency;
            });

        $this->countData = FieldLeadership::whereHas('company', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })
            ->where('published', FieldLeadershipType::Publish)
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->get()
            ->count();

        $this->limit = $this->countData;
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

        if ($field == 'detail_company') {
            $this->searchDetailCompany = null;
            unset($this->sortSelected['detail_company']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'department_id') {
            $this->searchDepartment = null;
            unset($this->sortSelected['department_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'section_id') {
            $this->searchSection = null;
            unset($this->sortSelected['section_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'area_location_id') {
            $this->searchLocation = null;
            unset($this->sortSelected['area_location_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'detail_location') {
            $this->searchDetailLocation = null;
        }

        if ($field == 'type') {
            $this->searchType = null;
            unset($this->sortSelected['type']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'member') {
            $this->searchMember = null;
        }

        if ($field == 'positive') {
            $this->searchPositive = null;
        }

        if ($field == 'risk_condition') {
            $this->searchRiskCondition = null;
        }

        if ($field == 'category') {
            $this->searchCategory = null;
            unset($this->sortSelected['category']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'potency') {
            $this->searchPotency = null;
            unset($this->sortSelected['potency']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'repair_action') {
            $this->searchRepairAction = null;
        }

        if ($field == 'pja') {
            $this->searchPja = null;
        }

        if ($field == 'condition_type') {
            $this->searchConditionType = null;
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
            return FieldLeadership::when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when(isset($this->sortSelected['company_id']), function ($query) {
                        $query->whereIn('company_id', $this->sortSelected['company_id']);
                    })
                        ->when(isset($this->sortSelected['detail_company']), function ($query) {
                            $query->whereIn('detail_company', $this->sortSelected['detail_company']);
                        })
                        ->when(isset($this->sortSelected['ccow_id']), function ($query) {
                            $query->whereIn('ccow_id', $this->sortSelected['ccow_id']);
                        })
                        ->when(isset($this->sortSelected['department_id']), function ($query) {
                            $query->whereIn('department_id', $this->sortSelected['department_id']);
                        })
                        ->when(isset($this->sortSelected['section_id']), function ($query) {
                            $query->whereIn('section_id', $this->sortSelected['section_id']);
                        })
                        ->when(isset($this->sortSelected['area_location_id']), function ($query) {
                            $query->whereIn('area_location_id', $this->sortSelected['area_location_id']);
                        })
                        ->when(isset($this->sortSelected['detail_location']), function ($query) {
                            $query->whereIn('detail_location', $this->sortSelected['detail_location']);
                        })
                        ->when(isset($this->sortSelected['type']), function ($query) {
                            $query->whereIn('type', $this->sortSelected['type']);
                        })
                        ->when(isset($this->sortSelected['category']), function ($query) {
                            $query->whereHas('risks', function ($query) {
                                $query->whereIn('category_id', $this->sortSelected['category']);
                            });
                        })
                        ->when(isset($this->sortSelected['potency']), function ($query) {
                            $query->whereHas('risks', function ($query) {
                                $query->whereIn('potency_id', $this->sortSelected['potency']);
                            });
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
                ->when(!empty($this->searchDepartment), function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchDepartment . '%');
                    });
                })
                ->when(!empty($this->searchSection), function ($query) {
                    $query->whereHas('section', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchSection . '%');
                    });
                })
                ->when(!empty($this->searchLocation), function ($query) {
                    $query->whereHas('areaLocation', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchLocation . '%');
                    });
                })
                ->when(!empty($this->searchDetailCompany), function ($query) {
                    $query->where('detail_company', 'like', '%' . $this->searchDetailCompany . '%');
                })
                ->when(!empty($this->searchDetailLocation), function ($query) {
                    $query->where('detail_location', 'like', '%' . $this->searchDetailLocation . '%');
                })
                ->when(!empty($this->searchType), function ($query) {
                    $query->where('type', 'like', '%' . $this->searchType . '%');
                })
                ->when(!empty($this->searchMember), function ($query) {
                    $query->whereHas('members', function ($query) {
                        $query->whereHas('employee', function ($query) {
                            $query->where('name', 'like', '%' . $this->searchMember . '%');
                        });
                    });
                })
                ->when(!empty($this->searchPositive), function ($query) {
                    $query->whereHas('positives', function ($query) {
                        $query->where('description', 'like', '%' . $this->searchPositive . '%');
                    });
                })
                ->whereHas('risks', function ($query) {
                    $query->when(!empty($this->searchRiskCondition), function ($query) {
                        $query->where('risk_condition', 'like', '%' . $this->searchRiskCondition . '%');
                    })->when(!empty($this->searchCategory), function ($query) {
                        $query->whereHas('category', function ($query) {
                            $query->where('name', 'like', '%' . $this->searchCategory . '%');
                        });
                    })->when(!empty($this->searchPotency), function ($query) {
                        $query->whereHas('potency', function ($query) {
                            $query->where('name', 'like', '%' . $this->searchPotency . '%');
                        });
                    })->when(!empty($this->searchRepairAction), function ($query) {
                        $query->where('repair_action', 'like', '%' . $this->searchRepairAction . '%');
                    });
                })
                ->when(!empty($this->searchPja), function ($query) {
                    $query->whereHas('pja', function ($query) {
                        $query->whereHas('user', function ($query) {
                            $query->where('name', 'like', '%' . $this->searchPja . '%');
                        });
                    });
                })
                ->whereHas('company', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->when(!empty($this->search), function ($query) {
                    $query->search($this->search);
                })
                ->when(!empty($this->startDate) && !empty($this->endDate), function ($query) {
                    $start = Carbon::parse($this->startDate)->format('Y-m-d');
                    $end = Carbon::parse($this->endDate)->format('Y-m-d');

                    $query->whereBetween('date', [$start, $end]);
                })
                ->where('published', FieldLeadershipType::Publish)
                ->where('status', FieldLeadershipType::OnReviewApproval)
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
        return view('fieldleadership::livewire.listing.approval.request-review-approval-page')->layout('fieldleadership::layouts.app');
    }
}
