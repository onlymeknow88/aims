<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\Performance;

class HealthPerformanceChart extends Component
{
    public function render()
    {
        $get = Performance::where('visible', 'true')
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        $data = [];
        $color = ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#ECF39E'];
        foreach ($get as $index => $list) {
            $data[] = [
                'label' => 'Performance ' . $index,
                'backgroundColor'   => '#D9DC30',
                'data'  =>  [$list->rkk, $list->cmr, $list->mmr, $list->ssr, $list->asr],
                'borderColor' => $color[$index],
            ];
        }
        return view('livewire.main-dashboard.public.widgets.health-performance-chart', ['data' => $data]);
    }
}
