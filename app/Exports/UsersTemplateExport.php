<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\UsersTemplateSheet;
use App\Exports\Sheets\DepartmentsSheet;
use App\Exports\Sheets\RolesSheet;

class UsersTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new UsersTemplateSheet(),
            new DepartmentsSheet(),
            new RolesSheet(),
        ];
    }
}
