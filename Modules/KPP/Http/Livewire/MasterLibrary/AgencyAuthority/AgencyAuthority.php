<?php

namespace Modules\KPP\Http\Livewire\MasterLibrary\AgencyAuthority;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\KPP\Entities\KppAgencyAuthority as AgencyAuthorityModel;

class AgencyAuthority extends Component
{
    use LivewireAlert;

    public $idAgencyAuthority;
    public $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function saved()
    {
        $this->validate();
        if ($this->idAgencyAuthority) {
            $category = AgencyAuthorityModel::find($this->idAgencyAuthority);
            $category->update([
                'name' => $this->name
            ]);

            $this->alert('success', 'Data berhasil diupdate!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('kpp::master-library.agency-authority.partials.table-maker', 'refreshComponent');
        } else {
            AgencyAuthorityModel::create([
                'name' => $this->name
            ]);

            $this->closeModal();

            $this->emitTo('kpp::master-library.agency-authority.partials.table-maker', 'refreshComponent');

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
        return view('kpp::livewire.master-library.agency-authority.agency-authority')->layout('kpp::layouts.app');
    }
}
