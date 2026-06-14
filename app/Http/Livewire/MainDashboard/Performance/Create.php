<?php

namespace App\Http\Livewire\MainDashboard\Performance;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\MainDashboard\Performance;

class Create extends Component
{

    public $input, $Id;

    protected $rules = [
        'input.month' => 'required',
        'input.rkk' => 'required|numeric',
        'input.cmr' => 'required|numeric',
        'input.mmr' => 'required|numeric',
        'input.ssr' => 'required|numeric',
        'input.asr' => 'required|numeric'
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
            $Performance = Performance::where('id', $id)->first();
            $Performance->month = date('M Y', strtotime($Performance->month));
            $this->input = json_decode($Performance, true);
        }
    }


    public function store()
    {
        //input 
        $input = $this->input;

        //validate
        $validation = [
            'input.month' => 'required',
            'input.rkk' => 'required|numeric',
            'input.cmr' => 'required|numeric',
            'input.mmr' => 'required|numeric',
            'input.ssr' => 'required|numeric',
            'input.asr' => 'required|numeric'
        ];
        $this->validate($validation);

        //create or update
        $input['user_id'] = Auth::id();
        $input['month'] = date('Y-m-d', strtotime($input['month'] . '-1'));
        $input['visible'] = 'true';
        unset($input['id']);
        Performance::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('performance_index');
    }


    public function render()
    {
        return view('livewire.main-dashboard.performance.create')
        ->extends('layouts.no-header');
    }
}
