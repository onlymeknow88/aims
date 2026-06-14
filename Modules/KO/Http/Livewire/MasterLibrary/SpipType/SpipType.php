<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\SpipType;

use Livewire\Component;
use Modules\KPP\Entities\RuleType;

class SpipType extends Component
{
    public $idType;
    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function saved()
    {
        $this->validate();
        if ($this->idType) {
            $category = RuleType::find($this->idType);
            $category->update([
                'name' => $this->name
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data berhasil di update'
            ]);

            $this->closeModal();

            $this->emitTo('ko::master-library.spip-type.partials.table-maker', 'refreshComponent');
        } else {
            RuleType::create([
                'name' => $this->name
            ]);

            $this->closeModal();

            $this->emitTo('ko::master-library.spip-type.partials.table-maker', 'refreshComponent');

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data berhasil di simpan'
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('ko::livewire.master-library.spip-type.spip-type')->layout('ko::layouts.app');
    }
}
