<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Maker;

use App\Models\IbprBowty\IbprForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListForm extends Component
{

    public $field_id;
    public $forms = [];
    public $user;


    public function mount($id)
    {
        $this->field_id = $id;
        $this->user = User::with(['employee', 'department'])->find(Auth::user()->id);
        $this->forms = IbprForm::where('ibpr_id', $id)->get();

    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.maker.list')->extends('layouts.no-header');
    }
}
