<?php

namespace App\Http\Livewire\MainDashboard\K3lhAward;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\MainDashboard\K3lhAward;

class Create extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $input, $Id;

    protected $rules = [
        'input.month'   => 'required',
        'input.rank' => 'required',
        'input.company' => 'required',
        'input.grade' => 'required',
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
            $K3lhAward = K3lhAward::where('id', $id)->first();
            $K3lhAward->month = date('M Y', strtotime($K3lhAward->month));
            $this->input = json_decode($K3lhAward, true);
        }
    }


    public function store()
    {
        //input
        $input = $this->input;

        //validate
        $validation = [
            'input.month'   => 'required',
            'input.rank'   => 'required',
            'input.company' => 'required',
            'input.grade' => 'required'
        ];
        $this->validate($validation);

        //create or update
        $input['user_id'] = Auth::id();
        $input['month'] = date('Y-m-d', strtotime($input['month'] . '-1'));
        $input['visible'] = 'true';
        unset($input['id']);
        K3lhAward::updateOrCreate(
            ['id' => $this->Id],
            $input
        );

        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('k3lh_award_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.k3lh-award.create')
        ->extends('layouts.no-header');
    }
}
