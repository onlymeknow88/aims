<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Iadl\Maker;

use App\Models\IbprBowty\IadlForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListFormIadl extends Component
{

    public $field_id;
    public $forms = [];
    public $user;


    public function mount($id)
    {
        $this->field_id = $id;
        $this->user = User::with(['employee', 'department'])->find(Auth::user()->id);
        $this->forms = IadlForm::where('iadl_id', $id)->get();

    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.iadl.maker.list')->extends('layouts.no-header');
    }
}
