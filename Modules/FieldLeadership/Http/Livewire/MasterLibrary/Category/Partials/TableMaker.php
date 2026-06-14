<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\Category\Partials;

use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TableMaker extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectAll = false;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $latestUpdate;
    public $search;
    public $limit;
    public $countData;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $last = FieldLeadershipCategory::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->countData = FieldLeadershipCategory::get()->count();

        $this->limit = $this->countData;
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'limit') {
            if ($value > $this->countData) {
                $this->limit = $this->countData;
            } else {
                $this->limit = $value;
            }
        }
    }

    public function searchUpdated($search)
    {
        $this->search = $search;
    }

    public function getCategoriesProperty()
    {
        return FieldLeadershipCategory::search($this->search)->paginate(10);
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
            $this->itemSelected = $this->categories->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->categories->count();

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

    public function edit($id)
    {
        $category = FieldLeadershipCategory::find($id);

        $this->dispatchBrowserEvent('edit', $category);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $category = FieldLeadershipCategory::find($item);
            $category->delete();
        }

        $this->flash('success', 'Data berhasil di hapus!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('fieldleadership::livewire.master-library.category.partials.table-maker')->layout('fieldleadership::layouts.app');
    }
}
