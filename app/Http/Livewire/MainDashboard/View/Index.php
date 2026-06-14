<?php

namespace App\Http\Livewire\MainDashboard\View;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.main-dashboard.view.index')
        ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
