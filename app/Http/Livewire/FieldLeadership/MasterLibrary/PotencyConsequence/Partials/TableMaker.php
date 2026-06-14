<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\PotencyConsequence\Partials;

use App\Models\FieldLeadershipPotencyAndConsequnce;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TableMaker extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $latestUpdate;
    public $search;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        $last = FieldLeadershipPotencyAndConsequnce::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');
    }

    public function searchUpdated($search)
    {
        $this->search = $search;
    }

    public function getPotenciesProperty()
    {
        return FieldLeadershipPotencyAndConsequnce::search($this->search)->paginate(10);
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

    public function edit($id)
    {
        $potency = FieldLeadershipPotencyAndConsequnce::find($id);

        $this->dispatchBrowserEvent('edit', $potency);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $potency = FieldLeadershipPotencyAndConsequnce::find($item);
            $potency->delete();
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
        return view('livewire.field-leadership.master-library.potency-consequence.partials.table-maker')->layout('livewire.field-leadership.layouts.app');
    }
}
