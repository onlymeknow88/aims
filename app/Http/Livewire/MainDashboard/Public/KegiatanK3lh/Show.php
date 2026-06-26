<?php

namespace App\Http\Livewire\MainDashboard\Public\KegiatanK3lh;

use Livewire\Component;
use App\Models\MainDashboard\K3lhActivities;

class Show extends Component
{
    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $data = K3lhActivities::where('slug', $this->slug)
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
        if ($data->url) {
            $data->url = route('dashboard.files.stream', ['id' => $data->id, 'type' => 'activities']);
        }
        return view('livewire.main-dashboard.public.kegiatan-k3lh.show', ['data' => $data])
        ->extends('layouts.no-header');
    }
}
