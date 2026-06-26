<?php

namespace App\Http\Livewire\MainDashboard\Public\NewsAndUpdate;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\MainDashboard\NewsAndUpdate as News_And_Update;

class Show extends Component
{

    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $data = News_And_Update::where('slug', $this->slug)
            ->where('visible', 'true')
            ->selectRaw(
                "*,
                DATE_FORMAT(created_at, '%d %b %Y %h:%i %p  ') as post_at"
            )
            ->first();
        if (empty($data)) {
            return view('livewire.main-dashboard.public.error')
                ->extends('layouts.main-dashboard.dashboard-white');
        }

        $data->description = str_replace("&nbsp;", ' ', $data->description);
        if ($data->url) {
            $data->url = route('dashboard.files.stream', ['id' => $data->id, 'type' => 'news']);
        }
        return view('livewire.main-dashboard.public.news-and-update.show', ['data' => $data])
            ->extends('layouts.no-header');
    }
}
