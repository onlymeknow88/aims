<?php

namespace App\Http\Livewire\Mcu\Patient;

use App\Models\Mcu\MedicalHistory;
use Livewire\Component;

class Dashboard extends Component
{

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;

    public function render()
    {
        $dataTables = MedicalHistory::where('employee_id', 2)->limit(1)->with('employee')->get();
        return view('livewire.mcu.patient.dashboard'
            , ['dataTables' => $dataTables]
        );
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
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
    // public function render()
    // {
    //     return view('livewire.mcu.patient.dashboard');
    // }
}
