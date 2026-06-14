<?php

namespace App\Exports\IbprAndBowtie;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventExport implements FromView, WithStyles, WithDrawings
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function view(): View
    {
        return view('export.ibpr-and-bowtie.event-excel', ['event' => $this->event]);
    }

    /**
     * @throws Exception
     */
    public function drawings(): array
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/frame_4.png'));
        $drawing->setHeight(300);
        $drawing->setCoordinates('J11');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo');
        $drawing2->setDescription('This is my logo');
        $drawing2->setPath(public_path('/images/frame_5.png'));
        $drawing2->setHeight(300);
        $drawing2->setCoordinates('X11');

        return [$drawing, $drawing2];
    }

    public function styles(Worksheet $sheet): void
    {
        // Atur gaya wrap text untuk semua kolom
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setWrapText(true);
    }
}
