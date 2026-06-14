<?php

namespace App\Exports\CoE;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; //autosize
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;

use App\Models\COE\Event;
use DB;
use Carbon\Carbon;


class CoEExport implements FromView, WithTitle, WithDefaultStyles, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return new Color(Color::COLOR_BLUE);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('c')->setAutoSize(true);  
            },
        ];
    }

    public function view(): View
    {
        $now = Carbon::now();
        $curent_year = $now->year;
        $events = Event::whereYear('start_date', $curent_year)->get();

        $month = [];
        for ($i=1; $i < 13; $i++) {
            $month[] = $now->month($i)->daysInMonth;
        }

        $data = [];
        $data['month'] = $month;
        $data['event'] = $events;

        // $data = $this->data;
        // $event =  Event::whereYear('start_date', 2023)
        //     ->groupBy('related_event_id')
        //     ->get([DB::raw('related_event_id as related_event_id')]);
        // for ($month = 1; $month <= 12; $month++) {
        //     Event::whereYear('star_date', 2023);
        //     $data[] = '';
        // }
// dd($events);
        return view('export.CoE.CoE', compact('data'));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'CoE';
    }
}
