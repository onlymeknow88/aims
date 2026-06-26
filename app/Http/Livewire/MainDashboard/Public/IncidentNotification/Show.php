<?php

namespace App\Http\Livewire\MainDashboard\Public\IncidentNotification;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\MainDashboard\IncidentNotification;

class Show extends Component
{

    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $data = IncidentNotification::where('slug', $this->slug)
            ->where('visible', 'true')
            ->selectRaw("
                *,
                DATE_FORMAT(created_at, '%d %b %Y %h:%i %p  ') as post_at
            ")
            ->first();
        if (empty($data)) {
            return view('livewire.main-dashboard.public.error')
                ->extends('layouts.main-dashboard.dashboard-white');
        }

        $data->description = str_replace("&nbsp;", ' ', $data->description);
        if ($data->url) {
            $data->url = route('dashboard.files.stream', ['id' => $data->id, 'type' => 'incident']);
        }
        return view('livewire.main-dashboard.public.incident-notification.show', ['data' => $data])
            ->extends('layouts.no-header');
    }
}
