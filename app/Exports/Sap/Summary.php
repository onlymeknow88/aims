<?php

namespace App\Exports\SAP;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; //autosize
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\MV_registration;

class Summary implements FromView, WithTitle, WithStyles, ShouldAutoSize
{
    public $months, $employee;

    public function __construct($months, $employee)
    {
        $this->months;
        $this->employee;
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
        $employee= $this->employee;
        return view('Sap::livewire.summary.components.table_summary', compact('months','employee'));
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'ALL';
    }
}
