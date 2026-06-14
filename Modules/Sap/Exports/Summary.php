<?php

namespace Modules\Sap\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; //autosize
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Summary implements FromView, WithTitle, WithStyles, ShouldAutoSize
{
    public $months, $employee;

    public function __construct($months, $employee)
    {
        $this->months = $months;
        $this->employee = $employee ;
    }

    /**
     * @return Builder
     */

    public function styles(Worksheet $sheet)
    {
    }

    public function view(): View
    {
        $months = $this->months;
        $employee = $this->employee;
        return view('sap::livewire.summary.exports.table_summary', [
            'months' => $months,
            'employee' => $employee
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'ALL';
    }
}
