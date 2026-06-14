<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class HomeNew extends Component
{
    public function render()
    {
        return view('livewire.dashboard.home-new')->extends('layouts.dashboard-white');
    }
}
