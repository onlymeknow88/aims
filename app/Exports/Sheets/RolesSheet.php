<?php

namespace App\Exports\Sheets;

use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        return Role::select('name')->get();
    }

    public function title(): string
    {
        return 'Roles';
    }

    public function headings(): array
    {
        return ['Role Name'];
    }
}
