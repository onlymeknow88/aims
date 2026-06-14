<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\K3lhActivities;

class KegiatanK3lh extends Component
{
    public function render()
    {
        $data = K3lhActivities::take(12)
            ->where('visible', 'true')
            ->get();
        return view('livewire.main-dashboard.public.widgets.kegiatan-k3lh', ['data' => $data]);
    }
}
