<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use App\Models\MainDashboard\Banner;

class ImageBanner extends Component
{
    public function render()
    {
        $banner0 = Banner::where('visible', 'true')
            ->first();
        if ($banner0) {
            $banner0 = $banner0->url;
        }
        return view('livewire.main-dashboard.public.widgets.image-banner', ['banner0' => $banner0]);
    }
}
