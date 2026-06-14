<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\SafetyPerformance;

class SafetyPerformanceChart extends Component
{
    public function render()
    {
        $get = SafetyPerformance::where('visible', 'true')
            ->orderBy('created_at', 'DESC')
            ->take(5)->get();

        $data = [];
        $color = ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#ECF39E'];
        foreach ($get as $index => $list) {
            $data[] = [
                'label' => 'Performance ' . $index,
                'backgroundColor'   => '#D9DC30',
                'data'  =>  [$list->aifr, $list->ainfr, $list->lti_fr, $list->lti_sr],
                'borderColor' => $color[$index],
            ];
        }
        return view('livewire.main-dashboard.public.widgets.safety-performance-chart', ['data' => $data]);
    }
}
