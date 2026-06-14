<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateBowtiePerformanceExport implements FromView, WithStyles
{
    public function view(): View
    {
        return view('view-performance');
    }

    public function styles(Worksheet $sheet)
    {
        // Atur gaya wrap text untuk semua kolom
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setWrapText(true);
    }
}
