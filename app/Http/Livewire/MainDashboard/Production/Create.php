<?php

namespace App\Http\Livewire\MainDashboard\Production;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\MainDashboard\Production;

class Create extends Component
{

    public $input, $Id;

    protected $rules = [
        'input.month' => 'required',
        'input.coal_shiping' => 'required|numeric',
        'input.waste_removal' => 'required|numeric',
        'input.coal_mining' => 'required|numeric',
        'input.coal_hauling' => 'required|numeric',
        'input.coal_barged' => 'required|numeric',
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
            $Production = Production::where('id', $id)->first();
            $Production->month = date('M Y', strtotime($Production->month));
            $this->input = json_decode($Production, true);
        }
    }


    public function store()
    {
        //input 
        $input = $this->input;

        //validate
        $validation = [
            'input.month' => 'required',
            'input.coal_shiping' => 'required|numeric',
            'input.waste_removal' => 'required|numeric',
            'input.coal_mining' => 'required|numeric',
            'input.coal_hauling' => 'required|numeric',
            'input.coal_barged' => 'required|numeric',
        ];
        $this->validate($validation);

        //create or update
        $input['user_id'] = Auth::id();
        $input['month'] = date('Y-m-d', strtotime($input['month'] . '-1'));
        $input['visible'] = 'true';
        unset($input['id']);
        Production::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('production_index');
    }


    public function render()
    {
        return view('livewire.main-dashboard.production.create')
        ->extends('layouts.no-header');
    }
}
