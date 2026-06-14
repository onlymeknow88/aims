<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\TypeKtaTta;

use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TypeKtaTtaPage extends Component
{
    use LivewireAlert;

    public $idType;
    public $title;
    public $code;
    public $type;
    public $edit = false;

    protected $rules = [
        'title' => 'required',
        'code' => 'required',
        'type' => 'required'
    ];

    public function edited()
    {
        $this->edit = true;
    }

    public function saved()
    {
        $this->validate();
        if ($this->idType) {
            $type = FieldLeadershipKtaAndTta::find($this->idType);
            $type->update([
                'code' => $this->code,
                'name' => $this->title,
                'type' => $this->type,
            ]);

            $this->alert('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.type-kta-tta.partials.table-maker', 'refreshComponent');
        } else {

            FieldLeadershipKtaAndTta::create([
                'code' => $this->code,
                'name' => $this->title,
                'type' => $this->type,
            ]);


            $this->closeModal();

            $this->emitTo('field-leadership.master-library.type-kta-tta.partials.table-maker', 'refreshComponent');

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
        return view('fieldleadership::livewire.master-library.type-kta-tta.type-kta-tta-page')->layout('fieldleadership::layouts.app');
    }
}
