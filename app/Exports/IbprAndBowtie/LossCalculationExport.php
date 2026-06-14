<?php

namespace App\Exports\IbprAndBowtie;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LossCalculationExport implements FromView, WithStyles
{
    protected $loss_calculations;

    public function __construct($loss_calculations)
    {
        $this->loss_calculations = $loss_calculations;
    }

    public function view(): View
    {
        return view('export.ibpr-and-bowtie.loss-calculation-excel', ['loss_calculations' => $this->loss_calculations]);
    }

    public function styles(Worksheet $sheet)
    {
        // Atur gaya wrap text untuk semua kolom
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setWrapText(true);
    }
}
