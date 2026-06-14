<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\Slideshow;

class VideoSlide extends Component
{
    public function render()
    {
        $slideshow = Slideshow::where('visible', 'true')
            ->whereNotNull('url')
            ->whereNotNull('attc')
            ->select('url')
            ->get();

        return view('livewire.main-dashboard.public.widgets.video-slide', ['slideshow' => $slideshow]);
    }
}
