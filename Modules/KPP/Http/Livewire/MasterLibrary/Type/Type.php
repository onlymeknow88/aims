<?php

namespace Modules\KPP\Http\Livewire\MasterLibrary\Type;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\KPP\Entities\KppRuleType;

class Type extends Component
{
    use LivewireAlert;

    public $idType;
    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function saved()
    {
        $this->validate();
        if ($this->idType) {
            $category = KppRuleType::find($this->idType);
            $category->update([
                'name' => $this->name
            ]);

            $this->alert('success', 'Data berhasil diupdate!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('kpp::master-library.type.partials.table-maker', 'refreshComponent');
        } else {
            KppRuleType::create([
                'name' => $this->name
            ]);

            $this->closeModal();

            $this->emitTo('kpp::master-library.type.partials.table-maker', 'refreshComponent');

            $this->alert('success', 'Data berhasil disimpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('kpp::livewire.master-library.type.type')->layout('kpp::layouts.app');
    }
}
