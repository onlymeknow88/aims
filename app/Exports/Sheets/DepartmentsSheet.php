<?php

namespace App\Exports\Sheets;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        return Department::select('name')->get();
    }

    public function title(): string
    {
        return 'Departments';
    }

    public function headings(): array
    {
        return ['Department Name'];
    }
}
