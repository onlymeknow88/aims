<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\LimitParameter\Partials;

use App\Models\FieldLeadershipParameter;
use Livewire\Component;

class TableMaker extends Component
{
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function getParametersProperty()
    {
        return FieldLeadershipParameter::all();
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
        $parameter = FieldLeadershipParameter::find($id);

        $this->dispatchBrowserEvent('edit', $parameter);
    }

    public function removeItem()
    {
        foreach ($this->itemSelected as $item) {
            $parameter = FieldLeadershipParameter::find($item);
            $parameter->delete();
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
        return view('livewire.field-leadership.master-library.limit-parameter.partials.table-maker')->layout('livewire.field-leadership.layouts.app');
    }
}
