<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\MainDashboard\NewsAndUpdate;

class NewsUpdate extends Component
{
    public function render()
    {
        $data = NewsAndUpdate::orderby('created_at', 'DESC')
            ->where('visible', 'true')
            ->selectRaw(
                "dashboard_news_and_update.*,
                DATE_FORMAT(dashboard_news_and_update.created_at, '%d %b %Y %h:%i %p  ') as post_at"
            )
            ->take(6)->get();
        $dataArr = [];
        foreach ($data as $list) {
            $list['description'] = strip_tags(Str::words($list->description, '25'));
            if ($list->url) {
                $list->url = route('dashboard.files.stream', ['id' => $list->id, 'type' => 'news']);
            }
            $dataArr[] = $list;
        }
        $data = (object) $dataArr;
        return view('livewire.main-dashboard.public.widgets.news-update', ['data' => $data]);
    }
}
