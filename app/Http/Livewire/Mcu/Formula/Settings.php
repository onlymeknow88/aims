<?php

namespace App\Http\Livewire\Mcu\Formula;

use App\Models\Mcu\FormulaBloodPressure;
use App\Models\Mcu\FormulaDislipidemia;
use Livewire\Component;

class Settings extends Component
{
    public $type;
    public $staff_id = 1;
    public $employee_id = null;

    // Blood Pressure
    public $FormulaBloodPressureById;
    public $modalAddFormulaBloodPressure;
    public $normal_a = 120;
    public $normal_b = 80;
    public $pre_a_1 = 120;
    public $pre_b_1 = 140;
    public $pre_a_2 = 80;
    public $pre_b_2 = 90;
    public $ht1_a_1 = 140;
    public $ht1_b_1 = 160;
    public $ht1_a_2 = 90;
    public $ht1_b_2 = 99;
    public $ht2_a = 160;
    public $ht2_b = 100;

    public $col_total = 300;
    public $tga = 300;

    public function setActiveBloodPressure($id)
    {
        try {
            $updated = FormulaBloodPressure::where('id', $id)->update([
                'status' => 'active',
            ]);

            if ($updated) {
                FormulaBloodPressure::where('id', '!=', $id)->update([
                    'status' => 'inactive',
                ]);
            }

            session()->flash('msg', __('Data Formula Blood Pressure Terupdate'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');

        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function editFormulaBloodPressure($id)
    {
        $this->FormulaBloodPressureById = FormulaBloodPressure::find($id);
        $this->modalAddFormulaBloodPressure = true;
    }
    public function saveFormulaBloodPressure()
    {
        $this->validate([
            'normal_a' => 'required',
            'normal_b' => 'required',
            'pre_a_1' => 'required',
            'pre_b_1' => 'required',
            'pre_a_2' => 'required',
            'pre_b_2' => 'required',
            'ht1_a_1' => 'required',
            'ht1_b_1' => 'required',
            'ht1_a_2' => 'required',
            'ht1_b_2' => 'required',
            'ht2_a' => 'required',
            'ht2_b' => 'required',
        ]);
        try {
            $FormulaBloodPressure = FormulaBloodPressure::create([
                'status' => 'active',
                'normal_a' => $this->normal_a,
                'normal_b' => $this->normal_b,
                'pre_a_1' => $this->pre_a_1,
                'pre_b_1' => $this->pre_b_1,
                'pre_a_2' => $this->pre_a_2,
                'pre_b_2' => $this->pre_b_2,
                'ht1_a_1' => $this->ht1_a_1,
                'ht1_b_1' => $this->ht1_b_1,
                'ht1_a_2' => $this->ht1_a_2,
                'ht1_b_2' => $this->ht1_b_2,
                'ht2_a' => $this->ht2_a,
                'ht2_b' => $this->ht2_b,
            ]);
            if ($FormulaBloodPressure) {
                FormulaBloodPressure::where('id', '!=', $FormulaBloodPressure->id)->update([
                    'status' => 'inactive',
                ]);
            }
            session()->flash('msg', __('Data Formula Blood Pressure Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }

    public function setActiveDislipidemia($id)
    {
        try {
            $updated = FormulaDislipidemia::where('id', $id)->update([
                'status' => 'active',
            ]);

            if ($updated) {
                FormulaDislipidemia::where('id', '!=', $id)->update([
                    'status' => 'inactive',
                ]);
            }
            session()->flash('msg', __('Data Formula Dislipidemia Terupdate'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');

        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function saveFormulaDislipidemia()
    {
        $this->validate([
            'col_total' => 'required',
            'tga' => 'required',
        ]);
        try {
            $FormulaDislipidemia = FormulaDislipidemia::create([
                'status' => 'active',
                'col_total' => $this->col_total,
                'tga' => $this->tga,
            ]);
            if ($FormulaDislipidemia) {
                FormulaDislipidemia::where('id', '!=', $FormulaDislipidemia->id)->update([
                    'status' => 'inactive',
                ]);
            }
            session()->flash('msg', __('Data Formula Dislipidemia Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('mcu::formula-settings');
        } catch (\Throwable$th) {
            session()->flash('msg', $th);
            session()->flash('alert', 'danger');
        }
    }
    public function render()
    {
        $FormulaDislipidemia = FormulaDislipidemia::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        $FormulaBloodPressure = FormulaBloodPressure::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        return view('livewire.mcu.formula.settings', ['FormulaDislipidemia' => $FormulaDislipidemia, 'FormulaBloodPressure' => $FormulaBloodPressure]);
    }
}
