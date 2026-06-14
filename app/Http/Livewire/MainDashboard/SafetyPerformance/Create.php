<?php

namespace App\Http\Livewire\MainDashboard\SafetyPerformance;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\MainDashboard\SafetyPerformance;

class Create extends Component
{
    public $input, $Id;

    protected $rules = [
        'input.aifr' => 'required|numeric',
        'input.ainfr' => 'required|numeric',
        'input.lti_fr' => 'required|numeric',
        'input.lti_sr' => 'required|numeric',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id = null)
    {
        //show is exist
        if ($id) {
            $this->Id = $id;
            $SafetyPerformance = SafetyPerformance::where('id', $id)->first();
            $SafetyPerformance->month = date('M Y', strtotime($SafetyPerformance->month));
            $this->input = json_decode($SafetyPerformance, true);
        }
    }


    public function store()
    {
        //validate
        $validation = [
            'input.month' => 'required',
            'input.aifr' => 'required|numeric',
            'input.ainfr' => 'required|numeric',
            'input.lti_fr' => 'required|numeric',
            'input.lti_sr' => 'required|numeric',
        ];
        $this->validate($validation);

        //create or update
        $input = $this->input;
        $input['user_id'] = Auth::id();
        $input['month'] = date('Y-m-d', strtotime($input['month'] . '-1'));
        $input['visible'] = 'true';
        $this->input = $input;

        unset($input['id']);
        SafetyPerformance::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('safety_performance_index');
    }


    public function render()
    {
        return view('livewire.main-dashboard.safety-performance.create')
        ->extends('layouts.no-header');
    }
}
