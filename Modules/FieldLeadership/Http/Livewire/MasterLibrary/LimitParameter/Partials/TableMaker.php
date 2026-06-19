<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\LimitParameter\Partials;

use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TableMaker extends Component
{
    use LivewireAlert;

    public $selectAll = false;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $limit;
    public $countData;
    public $latestUpdate;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        $last = FieldLeadershipParameter::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');

        $this->countData = FieldLeadershipParameter::get()->count();

        $this->limit = $this->countData;
    }

    private $cachedParameters = null;

    public function getParametersProperty()
    {
        if ($this->cachedParameters === null) {
            $this->cachedParameters = FieldLeadershipParameter::all();
        }
        return $this->cachedParameters;
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
            $this->itemSelected = $this->parameters->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->parameters->count();

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
        $parameter = FieldLeadershipParameter::find($id);

        $this->dispatchBrowserEvent('edit', $parameter);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $parameter = FieldLeadershipParameter::find($item);
            $parameter->delete();
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
        return view('fieldleadership::livewire.master-library.limit-parameter.partials.table-maker')->layout('fieldleadership::layouts.app');
    }
}
