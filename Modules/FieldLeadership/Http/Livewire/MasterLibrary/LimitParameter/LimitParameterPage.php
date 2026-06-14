<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\LimitParameter;

use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LimitParameterPage extends Component
{
    use LivewireAlert;

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

            $this->alert('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
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
        return view('fieldleadership::livewire.master-library.limit-parameter.limit-parameter-page')->layout('fieldleadership::layouts.app');
    }
}
