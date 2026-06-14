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
    public $all;

    public function __construct($all)
    {
        $this->all = $all;
    }

    /**
     * @return Builder
     */

    public function styles(Worksheet $sheet)
    {
       
    }

    public function view(): View
    {
        $all = $this->all;
        return view('sap:livewire.summary.index', compact('all'));
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'ALL';
    }
}
