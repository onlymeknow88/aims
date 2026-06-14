<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\Company;
use App\Models\User;

class DepartmentsTemplateSheet implements WithTitle, WithHeadings, WithEvents, FromArray
{
    public function title(): string
    {
        return 'import'; 
    }

    public function headings(): array
    {
        return [
            'company_id',
            'document_code',
            'name',
            'head_id',
        ];
    }
    
    public function array(): array
    {
        $company = Company::first();
        $head = User::first();
        
        return [
            [
                $company ? $company->company_name : '',
                'DEPT-001',
                'Sample Department',
                $head ? $head->name : '',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $compCount = Company::count();
                $userCount = User::count();
                
                if ($compCount > 0) {
                    $compValidation = $event->sheet->getCell('A2')->getDataValidation();
                    $compValidation->setType(DataValidation::TYPE_LIST);
                    $compValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $compValidation->setAllowBlank(true);
                    $compValidation->setShowInputMessage(true);
                    $compValidation->setShowErrorMessage(true);
                    $compValidation->setShowDropDown(true);
                    $compValidation->setErrorTitle('Input error');
                    $compValidation->setError('Value is not in list.');
                    $compValidation->setPromptTitle('Pick from list');
                    $compValidation->setPrompt('Please pick a company from the drop-down list.');
                    // Reference column A in Companies sheet
                    $compValidation->setFormula1('\'Companies\'!$A$2:$A$' . ($compCount + 1));
                    
                    // apply to A2:A1000
                    $event->sheet->setDataValidation('A2:A1000', clone $compValidation);
                }
                
                if ($userCount > 0) {
                    $userValidation = $event->sheet->getCell('D2')->getDataValidation();
                    $userValidation->setType(DataValidation::TYPE_LIST);
                    $userValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $userValidation->setAllowBlank(true);
                    $userValidation->setShowInputMessage(true);
                    $userValidation->setShowErrorMessage(true);
                    $userValidation->setShowDropDown(true);
                    $userValidation->setErrorTitle('Input error');
                    $userValidation->setError('Value is not in list.');
                    $userValidation->setPromptTitle('Pick from list');
                    $userValidation->setPrompt('Please pick a user from the drop-down list.');
                    // Reference column A in Users sheet
                    $userValidation->setFormula1('\'Users\'!$A$2:$A$' . ($userCount + 1));
                    
                    // apply to D2:D1000
                    $event->sheet->setDataValidation('D2:D1000', clone $userValidation);
                }
            }
        ];
    }
}
