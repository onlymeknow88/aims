<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\IncidentNotification as IncidentNotifications;
use Illuminate\Support\Facades\DB;

class IncidentNotification extends Component
{
    public function render()
    {
        $data = IncidentNotifications::where('visible', 'true')
            ->select(
                DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
                'case',
                'category',
                'slug'
            )
            ->take(6)
            ->get();
        return view('livewire.main-dashboard.public.widgets.incident-notification', ['data' => $data]);
    }
}
