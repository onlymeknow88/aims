<?php

namespace Modules\KPP\Http\Livewire\ObedienceMonitoring;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\KPP\Entities\KppObedience as ObedienceModel;
use Modules\KPP\Entities\KppRule;

class Contractor extends Component
{
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function getRulesProperty()
    {
        $company_id = Auth::user()->department->company->id;
        $obediences = ObedienceModel::where('company_id', $company_id)->latest();

        $rules = KppRule::has('obediences')->get();

        return $rules;
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            //array_merge($this->itemSelected, array($this->itemSelected[$key]));
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            ///array_push($this->itemSelected, $id);
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('kpp::livewire.obedience-monitoring.contractor')->layout('kpp::layouts.app');
    }
}
