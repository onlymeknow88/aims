<?php

namespace App\Http\Livewire\MainDashboard\Public\IncidentNotification;

use Livewire\Component;
use App\Models\MainDashboard\IncidentNotification;
use Illuminate\Support\Facades\Http;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;
    public $slug;
    public $search;


    public function render()
    {
        $data = IncidentNotification::orderby('created_at', 'DESC')
            ->where('visible', 'true')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orwhere('description', 'like', '%' . $this->search . '%')
            ->selectRaw(
                "dashboard_news_and_update.*,
            DATE_FORMAT(dashboard_news_and_update.created_at, '%d %b %Y %h:%i %p  ') as post_at"
            )
            ->paginate(10);

        $dataArr = [];
        foreach ($data as $list) {
            $description = strip_tags(Str::words($list->description, '100'));
            $list['description'] = str_replace("&nbsp;", ' ', $description);
            $dataArr[] = $list;
        }

        $data->data = $data;

        return view('livewire.main-dashboard.public.news-and-update.index', ['data' => $data])
            ->extends('layouts.no-header');
    }
}
