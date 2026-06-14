<?php

namespace App\Http\Livewire\MainDashboard\Public\KegiatanK3lh;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\MainDashboard\K3lhActivities;

class Index extends Component
{
    use WithPagination;

    public $slug;
    public $search = null;

    public function mount()
    {
    }

    public function render()
    {
        $data = K3lhActivities::orderby('created_at', 'DESC')
            ->where('visible', 'true')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orwhere('description', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.main-dashboard.public.kegiatan-k3lh.index', ['data' => $data])
            ->extends('layouts.no-header');
    }
}
