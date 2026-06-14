<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\Unit;

use App\Enums\KO\UnitRevokeStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Modules\KO\Entities\KoUnit as UnitModel;
use Modules\KO\Entities\KoSpipUnit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Unit extends Component
{

    use LivewireAlert;

    public $limit;
    public $countData;
    public $selectAll = false;

    public $itemSelected = [];
    public $countSelected = 0;

    public $columns = ['Description Unit', 'Identity Number', 'Brand', 'Serial Number', 'Production Year', 'Model Unit', 'Total Komisioning'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $searchCallSign;
    public $searchIdentityNumber;
    public $searchBrand;
    public $searchSerialNumber;

    public $fieldKoSpipUnit;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public $revoke_request_note;

    public function mount(): void
    {
        $this->selectedColumns = $this->columns;

        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        //column search
        $this->fieldKoSpipUnit = KoSpipUnit::all();

        $this->countData = $this->getUnitsProperty()->count();
        $this->limit = $this->countData;
    }

    public function removeItemFilter($field)
    {
        if ($field == 'ko_spip_unit_id') {
            unset($this->sortSelected['ko_spip_unit_id']);
            $this->sortFieldSelected = null;
        }

        if ($field == 'searchCallSign') {
            $this->searchCallSign = null;
        }

        if ($field == 'searchIdentityNumber') {
            $this->searchIdentityNumber = null;
        }

        if ($field == 'searchSerialNumber') {
            $this->searchSerialNumber = null;
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

    public function getUnitsProperty(): LengthAwarePaginator
    {
        DB::statement("SET SQL_MODE=''");
        return UnitModel::query()
            ->when(!empty($this->sortSelected), function ($query) {
                $query->where(function ($query) {
                    $query->when($this->sortFieldSelected == 'ko_spip_unit_id', function ($query) {
                        $query->whereIn('ko_spip_unit_id', $this->sortSelected['ko_spip_unit_id']);
                    });
                });
            })
            ->when(!empty($this->searchCallSign), function ($query) {
                $query->where('call_sign', 'like', '%' . $this->searchCallSign . '%');
            })
            ->when(!empty($this->searchIdentityNumber), function ($query) {
                $query->where('identity_number', 'like', '%' . $this->searchIdentityNumber . '%');
            })
            ->when(!empty($this->searchBrand), function ($query) {
                $query->where('brand', 'like', '%' . $this->searchBrand . '%');
            })
            ->when(!empty($this->searchSerialNumber), function ($query) {
                $query->where('serial_number', 'like', '%' . $this->searchSerialNumber . '%');
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortType)
            ->latest()
            ->paginate($this->limit);
    }

    public function revoke()
    {
        try {
            DB::beginTransaction();

            $units = UnitModel::whereIn('id', $this->itemSelected)->update([
                'revoke_requested_date' => date("Y-m-d"),
                'revoke_request_note' => $this->revoke_request_note,
                'revoke_status' => UnitRevokeStatus::AdminVerification()->value
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::master-library.unit.index');
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
            $this->itemSelected = $this->units->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->units->count();

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

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('ko::livewire.master-library.unit.unit')->layout('ko::layouts.app');
    }
}
