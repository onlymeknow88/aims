<?php

namespace Modules\Sap\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; //autosize
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataPersonal implements FromView, WithTitle, WithStyles, ShouldAutoSize
{
    public $months, $data;

    public function __construct($months, $data)
    {
        $this->months = $months;
        $this->data = $data;
    }

    /**
     * @return Builder
     */

    public function styles(Worksheet $sheet)
    {
    }

    public function view(): View
    {
        $months =  $this->months;
        $data = $this->data;
        return view('sap::livewire.monthly.exports.table_personal_data', [
            'months' => $months,
            'data' => $data
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
