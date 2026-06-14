<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\TypeKtaTta;

use App\Models\FieldLeadershipKtaAndTta;
use Livewire\Component;

class TypeKtaTtaPage extends Component
{
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

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di update'
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
        return view('livewire.field-leadership.master-library.type-kta-tta.type-kta-tta-page')->layout('livewire.field-leadership.layouts.app');
    }
}
