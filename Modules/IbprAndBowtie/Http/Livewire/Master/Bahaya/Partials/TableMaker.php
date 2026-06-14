<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Master\Bahaya\Partials;

use App\Models\IbprBowty\IbprMasterBahaya;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\KPP\Entities\KppAgencyAuthority;

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

    public function getBahayaProperty()
    {
        return IbprMasterBahaya::all();
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
            $this->itemSelected = $this->bahaya->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->bahaya->count();

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
        $bahaya = IbprMasterBahaya::find($id);

        $this->dispatchBrowserEvent('edit', $bahaya);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $bahaya = IbprMasterBahaya::find($item);
            $bahaya->delete();
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

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.master.bahaya.partials.table-maker');
    }
}
