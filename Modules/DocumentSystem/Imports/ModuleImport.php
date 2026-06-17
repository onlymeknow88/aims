<?php

namespace Modules\DocumentSystem\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Str;
use Modules\DocumentSystem\Entities\Module;

class ModuleImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        return new Module([
            'id'                  => (string) Str::uuid(),
            'index'               => str_pad((string)(int)$row['index'], 2, '0', STR_PAD_LEFT), // → "01", "02", dst
            'name'                => (string) $row['name'],
            'has_document_number' => filter_var($row['has_document_number'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function prepareForValidation(array $row, int $index): array
    {
        return [
            'index'               => (string) ($row['index'] ?? ''),
            'name'                => (string) ($row['name'] ?? ''),
            'has_document_number' => $row['has_document_number'] ?? false,
        ];
    }
}
