<?php

namespace App\Exports\Sheets;

use App\Enums\CompanyType;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyTypesSheet implements FromArray, WithTitle, WithHeadings
{
    public function array(): array
    {
        $types = CompanyType::getValues();
        $rows = [];
        foreach ($types as $type) {
            $rows[] = [$type];
        }
        return $rows;
    }

    public function title(): string
    {
        return 'Types';
    }

    public function headings(): array
    {
        return ['Type'];
    }
}
