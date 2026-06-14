<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Download Template')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DepartmentsTemplateExport(), 'departments_import_template.xlsx');
                })
                ->color('success')
                ->icon('heroicon-o-download'),
            ImportAction::make()
                ->uniqueField('name')
                ->fields([
                    ImportField::make('company_id')->label('Company')->required()
                        ->mutateBeforeCreate(fn($value) => \App\Models\Company::where('company_name', $value)->first()?->id ?? $value),
                    ImportField::make('document_code')->label('Code'),
                    ImportField::make('name')->required(),
                    ImportField::make('head_id')->label('Head')
                        ->mutateBeforeCreate(fn($value) => \App\Models\User::where('name', $value)->first()?->id ?? $value),
                ])
        ];
    }
}
