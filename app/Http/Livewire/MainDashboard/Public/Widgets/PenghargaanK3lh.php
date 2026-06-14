<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\K3lhAward;

class PenghargaanK3lh extends Component
{
    public function render()
    {
        $data = K3lhAward::orderBy('rank', 'ASC')
            ->orderBy('grade', 'ASC')
            ->take(5)
            ->get();
        return view('livewire.main-dashboard.public.widgets.penghargaan-k3lh', ['data' => $data]);
    }
}
