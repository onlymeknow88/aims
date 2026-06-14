<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Exports;

use App\Models\IbprBowty\IadlForm;
use App\Models\IbprBowty\IbprForm;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportIadl implements FromView, WithEvents
{

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    use Exportable;

    public $type;
    public $rangetime;

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'A1:'.$alphabet.$totalRow;
                $cellRangeBody      = 'A6:'.$alphabet.$totalRow;
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri')->setSize(10);
                $event->sheet->getDelegate()
                            ->getStyle('A1:AC5')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setWrapText(true);
                $event->sheet->getDelegate()
                            ->getStyle($cellRangeBody)
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                            ->setWrapText(true);
                $event->sheet->getDelegate()
                            ->getStyle('P2')
                            ->getAlignment()
                            ->setTextRotation(90)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()
                            ->getStyle('R2')
                            ->getAlignment()->setTextRotation(90);
                $event->sheet->getDelegate()
                            ->getStyle('S2')
                            ->getAlignment()
                            ->setTextRotation(90)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()
                            ->getStyle('AA2')
                            ->getAlignment()
                            ->setTextRotation(90)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()
                            ->getStyle('AB2')
                            ->getAlignment()
                            ->setTextRotation(90)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('C')->setWidth(5);
            },
        ];
    }

    public function view(): View
    {

        $data = IadlForm::where('iadl_id', $this->id)->orderBy('activity')->get();
        
        
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.export.iadl-excel', [
            'data' => $data
        ]);
    }
}
