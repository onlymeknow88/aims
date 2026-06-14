<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\StrategicProject as StrategicProjects;
use Illuminate\Support\Facades\DB;

class StrategicProject extends Component
{
    public function render()
    {
        $data = StrategicProjects::select(
            'dashboard_strategic_project.*',
            DB::raw('DATE_FORMAT(date, "%d %b %Y") as date')
        )
            ->take(6)
            ->where('visible', 'true')
            ->get();

        return view('livewire.main-dashboard.public.widgets.strategic-project', ['data' => $data]);
    }
}
