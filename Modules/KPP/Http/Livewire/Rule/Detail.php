<?php

namespace Modules\KPP\Http\Livewire\Rule;

use Illuminate\Http\Request;
use Livewire\Component;
use Modules\KPP\Entities\KppRule;

class Detail extends Component
{
    public $rule = [];

    public function mount(Request $request)
    {
        $this->rule = KppRule::findOrFail($request->id);
    }

    public function render()
    {
        return view('kpp::livewire.rule.detail')->extends('kpp::layouts.no-header');
    }
}
