<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\PotencyConsequence;

use App\Models\FieldLeadershipPotencyAndConsequnce;
use Livewire\Component;

class PotencyConsequencePage extends Component
{
    public $idPotency;
    public $title;
    public $code;
    public $edit = false;

    protected $rules = [
        'title' => 'required',
        'code' => 'required'
    ];

    public function edited()
    {
        $this->edit = true;
    }

    public function saved()
    {
        $this->validate();
        if ($this->idPotency) {
            $potency = FieldLeadershipPotencyAndConsequnce::find($this->idPotency);
            $potency->update([
                'code' => $this->code,
                'name' => $this->title
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di update'
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.potency-consequence.partials.table-maker', 'refreshComponent');
        } else {

            FieldLeadershipPotencyAndConsequnce::create([
                'code' => $this->code,
                'name' => $this->title
            ]);


            $this->closeModal();

            $this->emitTo('field-leadership.master-library.potency-consequence.partials.table-maker', 'refreshComponent');

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di simpan'
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('livewire.field-leadership.master-library.potency-consequence.potency-consequence-page')->layout('livewire.field-leadership.layouts.app');
    }
}
