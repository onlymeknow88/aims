<?php

namespace App\Exports\IbprAndBowtie;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CCAExport implements FromView, WithStyles
{
    protected $cca;

    public function __construct($cca)
    {
        $this->cca = $cca;
    }

    public function view(): View
    {
        return view('export.ibpr-and-bowtie.cca-excel', ['cca' => $this->cca]);
    }

    public function styles(Worksheet $sheet)
    {
        // Atur gaya wrap text untuk semua kolom
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setWrapText(true);
    }
}
