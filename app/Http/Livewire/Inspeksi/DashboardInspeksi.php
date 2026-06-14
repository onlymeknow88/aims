<?php

namespace App\Http\Livewire\Inspeksi;

use Livewire\Component;

class DashboardInspeksi extends Component
{
    public function render()
    {
        return view('livewire.inspeksi.dashboard-inspeksi')->extends('layouts.dashboard');
    }
}
