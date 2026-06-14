<?php

namespace Modules\CSMS\Http\Livewire\Inactive;

use App\Enums\CompanyType;
use App\Models\AreaLocation;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Kplh\Entities\KplhLabel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Lists extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $limit, $status, $criteria;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public $columns = ['CCOW', 'Jenis Badan Usaha', 'Nama Perusahaan', 'Alamat Perusahaan', 'Site Perusahaan', 'Nomor Ijin Badan Usaha', 'Perusahaan Induk', 'Nama Penanggung Jawab Bidder'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;
    public $idSelected;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $selectAll = false;
    public $sortSelected = [];
    public $sortFieldSelected;

    public $fieldTanggalInspeksi, $filterTanggalInspeksi, $filterTanggalInspeksi2;
    public $fieldJenisInspeksi, $searchIDInspeksi, $searchJenisInspeksi;
    public $fieldCcow, $searchCcow;
    public $fieldDepartemen, $searchDepartemen;
    public $fieldSection, $searchSection;
    public $fieldLokasi, $searchLokasi;
    public $fieldDetailLokasi, $searchDetailLokasi;
    public $fieldKTT, $searchKTT;
    public $fieldPja, $searchPJA;
    public $fieldStatus, $searchStatus;

    public $findMaker;
    public $superUser;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = KplhLabel::latest()->first();

        $this->latestUpdate = 'Update on ' . Carbon::parse($last->updated_at ?? null)->format('F d, Y . H:i A');

        $this->fieldCcow = Company::where('type', CompanyType::Internal)->get();
        $this->fieldDepartemen = Department::all();
        $this->fieldSection = Section::all();
        $this->fieldLokasi = AreaLocation::all();

        $this->countData = KplhLabel::where('maker_id', auth()->user()->id)
            ->get()
            ->count();

        if ($this->countData) {
            $this->limit = $this->countData;
            $this->findMaker = KplhLabel::where('maker_id', auth()->user()->employee->id)->get()->count();
        }
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

    public function getLabelListingsProperty()
    {
        return KplhLabel::when(!empty($this->sortSelected), function ($query) {
            $query->where(function ($query) {
                $query->when($this->sortFieldSelected == 'ccow_id', function ($query) {
                    array_key_exists('ccow_id', $this->sortSelected) ? $query->whereIn('ccow_id', $this->sortSelected['ccow_id']) : '';
                })->when($this->sortFieldSelected == 'inspect_criteria', function ($query) {
                    array_key_exists('inspect_criteria', $this->sortSelected) ? $query->whereIn('inspect_criteria', $this->sortSelected['inspect_criteria']) : '';
                })->when($this->sortFieldSelected == 'department_id', function ($query) {
                    array_key_exists('department_id', $this->sortSelected) ? $query->whereIn('department_id', $this->sortSelected['department_id']) : '';
                })->when($this->sortFieldSelected == 'section_id', function ($query) {
                    array_key_exists('section_id', $this->sortSelected) ? $query->whereIn('section_id', $this->sortSelected['section_id']) : '';
                })->when($this->sortFieldSelected == 'area_location_id', function ($query) {
                    array_key_exists('area_location_id', $this->sortSelected) ? $query->whereIn('area_location_id', $this->sortSelected['area_location_id']) : '';
                })->when($this->sortFieldSelected == 'detail_location', function ($query) {
                    array_key_exists('detail_location', $this->sortSelected) ? $query->whereIn('location_detail', $this->sortSelected['detail_location']) : '';
                })->when($this->sortFieldSelected == 'status', function ($query) {
                    array_key_exists('status', $this->sortSelected) ? $query->whereIn('status', $this->sortSelected['status']) : '';
                });
            });
        })
            ->when(!empty($this->searchIDInspeksi), function ($query) {
                $query->where('inspect_id', 'like', '%' . $this->searchIDInspeksi . '%');
            })
            ->when(!empty($this->filterTanggalInspeksi && !empty($this->filterTanggalInspeksi2)), function ($query) {
                $from = Carbon::parse($this->filterTanggalInspeksi)->format('Y-m-d');
                $to = Carbon::parse($this->filterTanggalInspeksi2)->format('Y-m-d');

                $query->whereBetween('date', [$from, $to]);
            })
            ->when(!empty($this->searchCcow), function ($query) {
                $query->whereHas('ccow', function ($query) {
                    $query->where('company_name', 'like', '%' . $this->searchCcow . '%');
                });
            })
            ->when(!empty($this->searchDepartemen), function ($query) {
                $query->whereHas('department', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchDepartemen . '%');
                });
            })
            ->when(!empty($this->searchSection), function ($query) {
                $query->whereHas('section', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchSection . '%');
                });
            })
            ->when(!empty($this->searchLokasi), function ($query) {
                $query->whereHas('areaLocation', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchLokasi . '%');
                });
            })
            ->when(!empty($this->searchDetailLokasi), function ($query) {
                $query->where('location_detail', 'like', '%' . $this->searchDetailLokasi . '%');
            })
            ->when(!empty($this->searchJenisInspeksi), function ($query) {
                $query->where('inspect_criteria', 'like', '%' . $this->searchJenisInspeksi . '%');
            })
            ->when(!empty($this->searchKTT), function ($query) {
                $query->whereHas('ktt', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchKTT . '%');
                });
            })
            ->when(!empty($this->searchPJA), function ($query) {
                $query->whereHas('pja', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchPJA . '%');
                    });
                });
            })
            ->where('maker_id', Auth::user()->id)
            ->with('inspection_data')
            ->orderByRaw("FIELD(status , 'draft', 'active', 'approved') ASC")
            ->orderBy('date', 'DESC')
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
        $this->SetSelected();
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
            $this->itemSelected = $this->LabelListings->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->LabelListings->count();

            $this->itemSelected = $this->itemSelected->toArray();
        }
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
        $this->SetSelected();
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $kplh = KplhLabel::find($item);

            DB::beginTransaction();

            $kplh->delete();

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
        // redirect()->route('mcu::medical-staff-reviewed');
    }

    public function SetSelected()
    {
        if ($this->countSelected == 1) {
            foreach ($this->itemSelected as $val) {
                $id = $val;
            }
            $this->idSelected = $id;
            $selectedData = KplhLabel::find($id);
            $this->status = $selectedData->status;
            $this->criteria = $selectedData->inspect_criteria;
        }
    }

    public function delete()
    {
        foreach ($this->itemSelected as $item) {
            $kplh = KplhLabel::find($item);

            DB::beginTransaction();

            $kplh->delete();

            DB::commit();
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

    public function render()
    {
        return view('csms::livewire.inactive.lists')->layout('csms::layouts.app');
    }
}
