<?php

namespace Modules\KPP\Http\Livewire\MasterLibrary\Type\Partials;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\KPP\Entities\KppRuleType;

class TableMaker extends Component
{
    use LivewireAlert;

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $selectAll = false;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function getTypesProperty()
    {
        return KppRuleType::all();
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
            $this->itemSelected = $this->types->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->types->count();

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
        $type = KppRuleType::find($id);

        $this->dispatchBrowserEvent('edit', $type);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $type = KppRuleType::find($item);
            $type->delete();
        }

        $this->alert('success', 'Data berhasil dihapus!', [
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
        return view('kpp::livewire.master-library.type.partials.table-maker');
    }
}
