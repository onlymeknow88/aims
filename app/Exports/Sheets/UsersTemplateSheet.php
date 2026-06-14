<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\Department;
use Spatie\Permission\Models\Role;

class UsersTemplateSheet implements WithTitle, WithHeadings, WithEvents, FromArray
{
    public function title(): string
    {
        return 'import'; 
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'department',
            'roles',
        ];
    }
    
    public function array(): array
    {
        $department = Department::first();
        $role = Role::first();
        
        return [
            [
                'John Doe',
                'johndoe@example.com',
                'password123',
                $department ? $department->name : '',
                $role ? $role->name : '',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $deptCount = Department::count();
                $roleCount = Role::count();
                
                if ($deptCount > 0) {
                    $deptValidation = $event->sheet->getCell('D2')->getDataValidation();
                    $deptValidation->setType(DataValidation::TYPE_LIST);
                    $deptValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $deptValidation->setAllowBlank(true);
                    $deptValidation->setShowInputMessage(true);
                    $deptValidation->setShowErrorMessage(true);
                    $deptValidation->setShowDropDown(true);
                    $deptValidation->setErrorTitle('Input error');
                    $deptValidation->setError('Value is not in list.');
                    $deptValidation->setPromptTitle('Pick from list');
                    $deptValidation->setPrompt('Please pick a department from the drop-down list.');
                    // Reference column A in Departments sheet
                    $deptValidation->setFormula1('\'Departments\'!$A$2:$A$' . ($deptCount + 1));
                    
                    // apply to D2:D1000
                    $event->sheet->setDataValidation('D2:D1000', clone $deptValidation);
                }
                
                if ($roleCount > 0) {
                    $roleValidation = $event->sheet->getCell('E2')->getDataValidation();
                    $roleValidation->setType(DataValidation::TYPE_LIST);
                    $roleValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $roleValidation->setAllowBlank(true);
                    $roleValidation->setShowInputMessage(true);
                    $roleValidation->setShowErrorMessage(true);
                    $roleValidation->setShowDropDown(true);
                    $roleValidation->setErrorTitle('Input error');
                    $roleValidation->setError('Value is not in list.');
                    $roleValidation->setPromptTitle('Pick from list');
                    $roleValidation->setPrompt('Please pick a role from the drop-down list.');
                    // Reference column A in Roles sheet
                    $roleValidation->setFormula1('\'Roles\'!$A$2:$A$' . ($roleCount + 1));
                    
                    // apply to E2:E1000
                    $event->sheet->setDataValidation('E2:E1000', clone $roleValidation);
                }
            }
        ];
    }
}
