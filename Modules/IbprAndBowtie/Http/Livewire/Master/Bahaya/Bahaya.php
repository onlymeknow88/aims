<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Master\Bahaya;

use App\Models\IbprBowty\IbprMasterBahaya;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Bahaya extends Component
{
    use LivewireAlert;

    public $idBahaya;
    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function saved()
    {
        $this->validate();
        if ($this->idBahaya) {
            $category = IbprMasterBahaya::find($this->idBahaya);
            $category->update([
                'name' => $this->name
            ]);

            $this->alert('success', 'Data berhasil diupdate!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('ibprandbowtie::master.bahaya.partials.table-maker', 'refreshComponent');
        } else {
            IbprMasterBahaya::create([
                'name' => $this->name
            ]);

            $this->closeModal();

            $this->emitTo('ibprandbowtie::master.bahaya.partials.table-maker', 'refreshComponent');

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
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.master.bahaya.bahaya')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }
}
