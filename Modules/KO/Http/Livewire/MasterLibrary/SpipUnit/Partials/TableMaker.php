<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\SpipUnit\Partials;

use Livewire\Component;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KPP\Entities\RuleType;

class TableMaker extends Component
{
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function getSpipUnitsProperty()
    {
        return KoSpipUnit::all();
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
        $type = RuleType::find($id);

        $this->dispatchBrowserEvent('edit', $type);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $type = RuleType::find($item);
            $type->delete();
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data berhasil di hapus'
        ]);

        $this->emit('refreshComponent');

        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('ko::livewire.master-library.spip-unit.partials.table-maker');
    }
}
