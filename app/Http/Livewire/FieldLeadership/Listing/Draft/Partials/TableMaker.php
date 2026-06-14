<?php

namespace App\Http\Livewire\FieldLeadership\Listing\Draft\Partials;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\FieldLeadership;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class TableMaker extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Date', 'CCOW', 'Company', 'Detail Company', 'Department', 'Section', 'Location', 'Detail Location', 'Type', 'Members', 'Positive Condition', 'Risk Condition', 'Repair Action', 'Status'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $this->selectedColumns = $this->columns;

        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');
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
    }

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        return FieldLeadership::where('published', FieldLeadershipType::Draft)
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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

            $fl->risks->files()->delete();

            $fl->risks()->delete();

            $fl->delete();
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text'  => 'Data berhasil di hapus'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('livewire.field-leadership.listing.draft.partials.table-maker')->layout('livewire.field-leadership.layouts.app');
    }
}
