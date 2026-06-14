<?php

namespace Modules\Coe\Http\Livewire;

use Auth;
use App\Enums\COE\COEStatus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Modules\Coe\Entities\Event as CalendarOfEvent;
use Modules\Coe\Entities\Category as CalenderCategory;

use Carbon\Carbon;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Home extends Component
{
    public $tes = '';
    public $calendarDate = '';
    public $count_event = 0;
    public $viewDetail = false;
    public CalendarOfEvent $detail;
    public $date;

    protected $listeners = ['openDetail'];

    public function mount()
    {
    }

    public function getEventsProperty()
    {
        if ($this->date) {
            $curent_year = Carbon::parse($this->date)->year;
        } else {
            $curent_year = Carbon::now()->year;
        }

        $events = CalendarOfEvent::whereYear('start_date', $curent_year)
            ->orWhereHas('category', function ($query) {
                $query->where('name', 'Umum');
            })->get();

        $this->count_event = count($events);

        $all_events = [];
        foreach ($events as $event) {
            $all_events[] = $this->event($event);
        }
        return json_encode($all_events);
    }

    private function event(CalendarOfEvent $event)
    {
        $row = [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start_date->toDateString(),
            'end' => $event->end_date->toDateString(),
        ];

        //Pending
        if ($event->status == COEStatus::Pending) {
            $color = [
                'color' => '#F58500',
                'textColor' => '#FFFFFF',
            ];
        }
        //Done
        elseif ($event->status == COEStatus::Done) {
            $color = [
                'color' => '#007D40',
                'textColor' => '#FFFFFF',
            ];
        }
        //Cancel
        elseif ($event->status == COEStatus::Canceled) {
            $color = [
                'color' => '#FF003D',
                'textColor' => '#FFFFFF',
            ];
        }

        return array_merge($row, $color);
    }

    public function openDetail($id)
    {
        $this->detail = CalendarOfEvent::find($id);
        $this->viewDetail = true;
    }

    public function render()
    {
        return view('coe::livewire.home')->extends('coe::layouts.no-header');
    }
}
