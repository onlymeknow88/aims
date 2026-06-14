<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AuditCriteriaExport implements FromArray,WithEvents,WithStyles //,WithHeadings
{
    protected $auditCriteria;

    public function __construct(array $auditCriteria)
    {
        $this->auditCriteria = $auditCriteria;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('B7:O8')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getRowDimension('11')->setRowHeight(100);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(100);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(30);

                $event->sheet->getDelegate()->mergeCells('B7:O8');
                $event->sheet->getDelegate()->mergeCells('B10:G11');
                $event->sheet->getDelegate()->mergeCells('B12:B18');
                $event->sheet->getDelegate()->mergeCells('B20:B30');
                $event->sheet->getDelegate()->mergeCells('B32:B55');
                $event->sheet->getDelegate()->mergeCells('B57:B105');
                $event->sheet->getDelegate()->mergeCells('B107:B124');
                $event->sheet->getDelegate()->mergeCells('B126:B130');
                $event->sheet->getDelegate()->mergeCells('B132:B138');

                $event->sheet->getDelegate()->getStyle('B10:G11')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $event->sheet->getDelegate()->getStyle('B12:B18')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B20:B30')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getDelegate()->getStyle('B32:B55')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        
                $event->sheet->getDelegate()->getStyle('B57:B105')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B107:B124')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B126:B130')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B132:B138')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



                $event->sheet->getDelegate()->mergeCells('H10:H11');
                $event->sheet->getDelegate()->mergeCells('I10:I11');
                $event->sheet->getDelegate()->mergeCells('J10:J11');
                
                $event->sheet->getDelegate()->mergeCells('K10:N10');
                $event->sheet->getDelegate()->getStyle('K10:N10')
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle("H10:H11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("I10:I11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("J10:J11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("K11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("L11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("M11")->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle("N11")->getAlignment()->setTextRotation(90);

                $event->sheet->getDelegate()->mergeCells('O10:O11');
                $event->sheet->getDelegate()->mergeCells('P10:P11');
                $event->sheet->getDelegate()->mergeCells('B11:G11');
                $event->sheet->getDelegate()->mergeCells('C12:G12');
                $event->sheet->getDelegate()->mergeCells('C13:G13');

                $event->sheet->getDelegate()->mergeCells('D14:G14');
                $event->sheet->getDelegate()->mergeCells('D15:G15');
                $event->sheet->getDelegate()->mergeCells('D16:G16');
                $event->sheet->getDelegate()->mergeCells('D17:G17');
                $event->sheet->getDelegate()->mergeCells('D18:G18');
                $event->sheet->getDelegate()->mergeCells('C20:G20');
                $event->sheet->getDelegate()->mergeCells('D21:G21');
                $event->sheet->getDelegate()->mergeCells('D22:G22');
                $event->sheet->getDelegate()->mergeCells('E23:G23');
                $event->sheet->getDelegate()->mergeCells('E24:G24');
                $event->sheet->getDelegate()->mergeCells('E25:G25');
                $event->sheet->getDelegate()->mergeCells('E26:G26');
                $event->sheet->getDelegate()->mergeCells('E27:G27');
                $event->sheet->getDelegate()->mergeCells('D28:G28');
                $event->sheet->getDelegate()->mergeCells('D29:G29');
                $event->sheet->getDelegate()->mergeCells('D30:G30');

                $event->sheet->getDelegate()->mergeCells('C32:G32');
                $event->sheet->getDelegate()->mergeCells('D33:G33');
                $event->sheet->getDelegate()->mergeCells('D34:G34');
                $event->sheet->getDelegate()->mergeCells('E35:G35');
                $event->sheet->getDelegate()->mergeCells('E36:G36');
                $event->sheet->getDelegate()->mergeCells('E37:G37');

                $event->sheet->getDelegate()->mergeCells('D38:G38');
                $event->sheet->getDelegate()->mergeCells('D39:G39');
                $event->sheet->getDelegate()->mergeCells('D40:G40');
                $event->sheet->getDelegate()->mergeCells('D41:G41');
                $event->sheet->getDelegate()->mergeCells('D42:G42');
                $event->sheet->getDelegate()->mergeCells('D43:G43');
                $event->sheet->getDelegate()->mergeCells('D44:G44');
                $event->sheet->getDelegate()->mergeCells('D45:G45');

                $event->sheet->getDelegate()->mergeCells('E46:G46');
                $event->sheet->getDelegate()->mergeCells('E47:G47');

                $event->sheet->getDelegate()->mergeCells('D48:G48');
                $event->sheet->getDelegate()->mergeCells('D49:G49');

                $event->sheet->getDelegate()->mergeCells('E50:G50');
                $event->sheet->getDelegate()->mergeCells('E51:G51');
                $event->sheet->getDelegate()->mergeCells('E52:G52');
                $event->sheet->getDelegate()->mergeCells('E53:G53');
                $event->sheet->getDelegate()->mergeCells('E54:G54');
                $event->sheet->getDelegate()->mergeCells('D55:G55');
                $event->sheet->getDelegate()->mergeCells('C57:G57');
                $event->sheet->getDelegate()->mergeCells('D58:G58');
                $event->sheet->getDelegate()->mergeCells('E59:G59');
                $event->sheet->getDelegate()->mergeCells('E60:G60');
                $event->sheet->getDelegate()->mergeCells('E61:G61');
                $event->sheet->getDelegate()->mergeCells('D62:G62');
                $event->sheet->getDelegate()->mergeCells('E63:G63');
                $event->sheet->getDelegate()->mergeCells('E64:G64');
                $event->sheet->getDelegate()->mergeCells('E65:G65');
                $event->sheet->getDelegate()->mergeCells('E66:G66');
                $event->sheet->getDelegate()->mergeCells('E67:G67');
                $event->sheet->getDelegate()->mergeCells('E68:G68');
                $event->sheet->getDelegate()->mergeCells('E69:G69');
                $event->sheet->getDelegate()->mergeCells('E70:G70');
                $event->sheet->getDelegate()->mergeCells('E71:G71');
                $event->sheet->getDelegate()->mergeCells('E72:G72');
                $event->sheet->getDelegate()->mergeCells('D73:G73');
                $event->sheet->getDelegate()->mergeCells('E74:G74');
                $event->sheet->getDelegate()->mergeCells('E75:G75');
                $event->sheet->getDelegate()->mergeCells('E76:G76');
                $event->sheet->getDelegate()->mergeCells('E77:G77');
                $event->sheet->getDelegate()->mergeCells('E78:G78');
                $event->sheet->getDelegate()->mergeCells('E79:G79');
                $event->sheet->getDelegate()->mergeCells('E80:G80');
                $event->sheet->getDelegate()->mergeCells('E81:G81');
                $event->sheet->getDelegate()->mergeCells('E82:G82');
                $event->sheet->getDelegate()->mergeCells('E83:G83');
                $event->sheet->getDelegate()->mergeCells('D84:G84');
                $event->sheet->getDelegate()->mergeCells('E85:G85');
                $event->sheet->getDelegate()->mergeCells('E86:G86');
                $event->sheet->getDelegate()->mergeCells('E87:G87');
                $event->sheet->getDelegate()->mergeCells('E88:G88');
                $event->sheet->getDelegate()->mergeCells('E89:G89');
                $event->sheet->getDelegate()->mergeCells('D90:G90');
                $event->sheet->getDelegate()->mergeCells('E91:G91');
                $event->sheet->getDelegate()->mergeCells('E92:G92');
                $event->sheet->getDelegate()->mergeCells('E93:G93');
                $event->sheet->getDelegate()->mergeCells('E94:G94');
                $event->sheet->getDelegate()->mergeCells('D95:G95');
                $event->sheet->getDelegate()->mergeCells('E96:G96');
                $event->sheet->getDelegate()->mergeCells('E97:G97');
                $event->sheet->getDelegate()->mergeCells('D98:G98');
                $event->sheet->getDelegate()->mergeCells('D99:G99');
                $event->sheet->getDelegate()->mergeCells('E100:G100');
                $event->sheet->getDelegate()->mergeCells('E101:G101');
                $event->sheet->getDelegate()->mergeCells('E102:G102');
                $event->sheet->getDelegate()->mergeCells('D103:G103');
                $event->sheet->getDelegate()->mergeCells('D104:G104');
                $event->sheet->getDelegate()->mergeCells('D105:G105');

                $event->sheet->getDelegate()->mergeCells('C107:G107');
                $event->sheet->getDelegate()->mergeCells('D108:G108');
                $event->sheet->getDelegate()->mergeCells('E109:G109');
                $event->sheet->getDelegate()->mergeCells('E110:G110');
                $event->sheet->getDelegate()->mergeCells('E111:G111');
                $event->sheet->getDelegate()->mergeCells('E112:G112');
                $event->sheet->getDelegate()->mergeCells('E113:G113');
                $event->sheet->getDelegate()->mergeCells('D114:G114');
                $event->sheet->getDelegate()->mergeCells('D115:G115');
                $event->sheet->getDelegate()->mergeCells('D116:G116');
                $event->sheet->getDelegate()->mergeCells('D117:G117');

                $event->sheet->getDelegate()->mergeCells('E118:G118');
                $event->sheet->getDelegate()->mergeCells('E119:G119');
                $event->sheet->getDelegate()->mergeCells('E120:G120');
                $event->sheet->getDelegate()->mergeCells('E121:G121');
                $event->sheet->getDelegate()->mergeCells('E122:G122');
                $event->sheet->getDelegate()->mergeCells('E123:G123');
                $event->sheet->getDelegate()->mergeCells('E124:G124');

                $event->sheet->getDelegate()->mergeCells('C126:G126');
                $event->sheet->getDelegate()->mergeCells('D127:G127');
                $event->sheet->getDelegate()->mergeCells('D128:G128');
                $event->sheet->getDelegate()->mergeCells('D129:G129');
                $event->sheet->getDelegate()->mergeCells('D130:G130');

                $event->sheet->getDelegate()->mergeCells('C132:G132');
                $event->sheet->getDelegate()->mergeCells('D133:G133');
                $event->sheet->getDelegate()->mergeCells('D134:G134');
                $event->sheet->getDelegate()->mergeCells('D135:G135');
                $event->sheet->getDelegate()->mergeCells('D136:G136');
                $event->sheet->getDelegate()->mergeCells('D137:G137');
                $event->sheet->getDelegate()->mergeCells('D138:G138');
                $event->sheet->getDelegate()->mergeCells('C139:G139');






                $event->sheet->getDelegate()->mergeCells('B19:J19');
                $event->sheet->getDelegate()->mergeCells('B31:J31');
                $event->sheet->getDelegate()->mergeCells('B56:J56');
                $event->sheet->getDelegate()->mergeCells('B106:J106');
                $event->sheet->getDelegate()->mergeCells('B125:J125');
                $event->sheet->getDelegate()->mergeCells('B131:J131');

                $event->sheet->getDelegate()->setCellValue('H12', '10%');
                $event->sheet->getDelegate()->setCellValue('H20', '15%');
                $event->sheet->getDelegate()->setCellValue('H32', '17%');
                $event->sheet->getDelegate()->setCellValue('H57', '35%');
                $event->sheet->getDelegate()->setCellValue('H107', '15%');
                $event->sheet->getDelegate()->setCellValue('H125', '3%');
                $event->sheet->getDelegate()->setCellValue('H132', '5%');
                $event->sheet->getDelegate()->setCellValue('H139', '100%');

               
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {

        
        return [
            'B7' => ['font' => ['bold' => true,'size'=>24]],
            'B10:G11' => ['font' => ['bold' => true]],
        ];
    }

    // public function headings(): array
    // {
    //     return [
    //         "Kriteria",
    //         "Nilai Elemen",
    //         "Nilai Sub Elemen",
    //         "Nilai Sub Sub Elemen",
    //         "Nilai Sub Elemen",
    //         "Nilai Sub Sub Elemen"
    //     ];
    // }

    public function array(): array
    {
        return $this->auditCriteria;
    }
}