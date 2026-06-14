<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        return User::select('name')->get();
    }

    public function title(): string
    {
        return 'Users';
    }

    public function headings(): array
    {
        return ['User Name'];
    }
}
