<?php

namespace App\Exports\IbprAndBowtie;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerformanceExport implements FromView, WithStyles
{
    protected $performances;

    public function __construct($performances)
    {
        $this->performances = $performances;
    }

    public function view(): View
    {
        return view('export.ibpr-and-bowtie.performance-excel', ['performances' => $this->performances]);
    }

    public function styles(Worksheet $sheet)
    {
        // Atur gaya wrap text untuk semua kolom
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setWrapText(true);
    }
}
