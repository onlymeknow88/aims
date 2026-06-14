<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Access\ApiModules;

class CalendarOfEventList extends Component
{
    public $data = [];

    public function mount($result)
    {
        $getData = [];
        foreach ($result['soon_event']  as $list) {
            $start_date = date('d M Y', strtotime($list['start_date']));
            $end_date = date('d M Y', strtotime($list['end_date']));

            $getData[] = [
                'date' =>  $start_date . ' - ' . $end_date,
                'title' => Strip_tags($list['title']),
            ];
        }

        $this->data = $getData;
    }


    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.calendar-of-event-list');
    }
}
