<?php

namespace App\Exports\Sheets;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        return Company::select('company_name')->get();
    }

    public function title(): string
    {
        return 'Companies';
    }

    public function headings(): array
    {
        return ['Company Name'];
    }
}
