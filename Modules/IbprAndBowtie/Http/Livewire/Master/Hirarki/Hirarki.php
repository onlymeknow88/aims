<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Master\Hirarki;

use App\Models\IbprBowty\IbprMasterHirarki;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Hirarki extends Component
{
    use LivewireAlert;

    public $idHirarki;
    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function saved()
    {
        $this->validate();
        if ($this->idHirarki) {
            $category = IbprMasterHirarki::find($this->idHirarki);
            $category->update([
                'name' => $this->name
            ]);

            $this->alert('success', 'Data berhasil diupdate!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('ibprandbowtie::master.hirarki.partials.table-maker', 'refreshComponent');
        } else {
            IbprMasterHirarki::create([
                'name' => $this->name
            ]);

            $this->closeModal();

            $this->emitTo('ibprandbowtie::master.hirarki.partials.table-maker', 'refreshComponent');

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
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.master.hirarki.hirarki')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }
}
