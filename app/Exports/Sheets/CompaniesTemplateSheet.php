<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\Company;
use App\Enums\CompanyType;

class CompaniesTemplateSheet implements WithTitle, WithHeadings, WithEvents, FromArray
{
    public function title(): string
    {
        return 'import'; 
    }

    public function headings(): array
    {
        return [
            'company_name',
            'document_code',
            'address',
            'email',
            'phone_number',
            'type',
            'parent_company_id',
        ];
    }
    
    public function array(): array
    {
        $parent = Company::first();
        $types = CompanyType::getValues();
        $type = count($types) > 0 ? $types[0] : '';
        
        return [
            [
                'Sample Company',
                'COMP-001',
                '123 Main St',
                'contact@sample.com',
                '08123456789',
                $type,
                $parent ? $parent->company_name : '',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $typeCount = count(CompanyType::getValues());
                $parentCount = Company::count();
                
                if ($typeCount > 0) {
                    $typeValidation = $event->sheet->getCell('F2')->getDataValidation();
                    $typeValidation->setType(DataValidation::TYPE_LIST);
                    $typeValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $typeValidation->setAllowBlank(true);
                    $typeValidation->setShowInputMessage(true);
                    $typeValidation->setShowErrorMessage(true);
                    $typeValidation->setShowDropDown(true);
                    $typeValidation->setErrorTitle('Input error');
                    $typeValidation->setError('Value is not in list.');
                    $typeValidation->setPromptTitle('Pick from list');
                    $typeValidation->setPrompt('Please pick a type from the drop-down list.');
                    // Reference column A in Types sheet
                    $typeValidation->setFormula1('\'Types\'!$A$2:$A$' . ($typeCount + 1));
                    
                    // apply to F2:F1000
                    $event->sheet->setDataValidation('F2:F1000', clone $typeValidation);
                }
                
                if ($parentCount > 0) {
                    $parentValidation = $event->sheet->getCell('G2')->getDataValidation();
                    $parentValidation->setType(DataValidation::TYPE_LIST);
                    $parentValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $parentValidation->setAllowBlank(true);
                    $parentValidation->setShowInputMessage(true);
                    $parentValidation->setShowErrorMessage(true);
                    $parentValidation->setShowDropDown(true);
                    $parentValidation->setErrorTitle('Input error');
                    $parentValidation->setError('Value is not in list.');
                    $parentValidation->setPromptTitle('Pick from list');
                    $parentValidation->setPrompt('Please pick a parent company from the drop-down list.');
                    // Reference column A in Parents sheet
                    $parentValidation->setFormula1('\'Parents\'!$A$2:$A$' . ($parentCount + 1));
                    
                    // apply to G2:G1000
                    $event->sheet->setDataValidation('G2:G1000', clone $parentValidation);
                }
            }
        ];
    }
}
