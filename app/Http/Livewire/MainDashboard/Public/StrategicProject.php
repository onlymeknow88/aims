<?php

namespace App\Http\Livewire\MainDashboard\Public;

use Livewire\Component;
use App\Models\MainDashboard\StrategicProject as StrategicProjects;

class StrategicProject extends Component
{
    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $data = StrategicProjects::where('slug', $this->slug)
            ->selectRaw(
                "*,
                DATE_FORMAT(created_at, '%d %b %Y %h:%i %p  ') as post_at"
            )
            ->where('visible', 'true')
            ->first();
        if (empty($data)) {
            return view('livewire.main-dashboard.public.error')
                ->extends('layouts.main-dashboard.dashboard-white');
        }
        if ($data->url) {
            $data->url = route('dashboard.files.stream', ['id' => $data->id, 'type' => 'strategic_project']);
        }
        return view('livewire.main-dashboard.public.strategic-project', ['data' => $data])
            ->extends('layouts.no-header');
    }
}
