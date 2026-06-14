<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\CompaniesTemplateSheet;
use App\Exports\Sheets\CompanyTypesSheet;
use App\Exports\Sheets\ParentCompaniesSheet;

class CompaniesTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CompaniesTemplateSheet(),
            new CompanyTypesSheet(),
            new ParentCompaniesSheet(),
        ];
    }
}
