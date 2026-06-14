<?php

namespace App\Exports\IbprAndBowtie;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BowtieExport implements WithMultipleSheets
{
    use Exportable;

    protected $bowtie;

    public function __construct($bowtie)
    {
        $this->bowtie = $bowtie;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->bowtie->events as $key => $event) {
            $sheets[] = new EventExport($event);
        }

        $sheets[] = new CCAExport($this->bowtie->cca);

        $sheets[] = new PerformanceExport($this->bowtie->performances);

        $sheets[] = new LossCalculationExport($this->bowtie->loss_calculations);

        return $sheets;
    }
}
