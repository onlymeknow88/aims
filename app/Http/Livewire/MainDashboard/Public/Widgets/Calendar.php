<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;

class Calendar extends Component
{
    public $events = [];

    public function mount(){
        $this->events = json_encode([
            // [
            //     'id' => 1,
            //     'title' => 'adaro - makan bersama',
            //     'start' => '2023-06-25',
            //     'color' => '#D2FFE9',
            //     'textColor' => '#009D50'
            // ],
            // [
            //     'id' => 2,
            //     'title' => 'adaro - Family Gathering - cancel',
            //     'start' => '2023-02-03',
            //     'end' => '2023-02-05',
            //     'color' => '#FFF8E5',
            //     'textColor' => '#F5B100'
            // ],
            // [
            //     'id' => 3,
            //     'title' => 'adaro - Family Gathering',
            //     'start' => '2023-02-04',
            //     'end' => '2023-02-07',
            //     'color' => '#FFDDE5',
            //     'textColor' => '#FF003D'
            // ],
            // [
            //     'id' => 4,
            //     'title' => 'adaro - libur',
            //     'start' => '2023-02-09T12:30:00',
            //     'end' => '2023-02-13T12:30:00',
            //     'allDay' => false,
            //     'color' => '#D2FFE9',
            //     'textColor' => '#009D50'
            // ]          
        ]);
    }
    public function render()
    {
        return view('livewire.main-dashboard.public.widgets.calendar');
    }
}
