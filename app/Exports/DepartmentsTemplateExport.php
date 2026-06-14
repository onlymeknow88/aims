<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\DepartmentsTemplateSheet;
use App\Exports\Sheets\CompaniesSheet;
use App\Exports\Sheets\UsersSheet;

class DepartmentsTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DepartmentsTemplateSheet(),
            new CompaniesSheet(),
            new UsersSheet(),
        ];
    }
}
