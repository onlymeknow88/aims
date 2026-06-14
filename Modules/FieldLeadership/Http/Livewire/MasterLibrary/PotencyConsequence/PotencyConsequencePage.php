<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\PotencyConsequence;

use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PotencyConsequencePage extends Component
{
    use LivewireAlert;

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

            $this->alert('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
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

            $this->alert('success', 'Data berhasil di simpan!', [
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
        return view('fieldleadership::livewire.master-library.potency-consequence.potency-consequence-page')->layout('fieldleadership::layouts.app');
    }
}
