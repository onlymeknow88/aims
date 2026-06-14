<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\LimitParameter;

use App\Models\FieldLeadershipParameter;
use Livewire\Component;

class LimitParameterPage extends Component
{
    public $idParameter;
    public $max_member;
    public $max_positive;
    public $max_risk;
    public $max_corrective;
    public $edit = false;

    protected $rules = [
        'max_member' => 'required',
        'max_positive' => 'required',
        'max_risk' => 'required',
        'max_corrective' => 'required'
    ];

    public function edited()
    {
        $this->edit = true;
    }

    public function saved()
    {
        $this->validate();
        if ($this->idParameter) {
            $parameter = FieldLeadershipParameter::find($this->idParameter);
            $parameter->update([
                'max_item_member' => $this->max_member,
                'max_item_positive_condition' => $this->max_positive,
                'max_item_risk_condition' => $this->max_risk,
                'max_item_corrective_action' => $this->max_corrective,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'max_member' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di update'
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.limit-parameter.partials.table-maker', 'refreshComponent');
        } else {

            FieldLeadershipParameter::create([
                'max_item_member' => $this->max_member,
                'max_item_positive_condition' => $this->max_positive,
                'max_item_risk_condition' => $this->max_risk,
                'max_item_corrective_action' => $this->max_corrective,
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.limit-parameter.partials.table-maker', 'refreshComponent');

            $this->dispatchBrowserEvent('swal', [
                'max_member' => 'Berhasil',
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
        return view('livewire.field-leadership.master-library.limit-parameter.limit-parameter-page')->layout('livewire.field-leadership.layouts.app');
    }
}
