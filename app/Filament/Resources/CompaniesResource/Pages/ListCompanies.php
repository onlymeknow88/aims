<?php

namespace App\Filament\Resources\CompaniesResource\Pages;

use App\Filament\Resources\CompaniesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompaniesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Download Template')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CompaniesTemplateExport(), 'companies_import_template.xlsx');
                })
                ->color('success')
                ->icon('heroicon-o-download'),
            ImportAction::make()
                ->uniqueField('document_code')
                ->fields([
                    ImportField::make('company_name')->required(),
                    ImportField::make('document_code')->label('Company Code')->required(),
                    ImportField::make('address'),
                    ImportField::make('email'),
                    ImportField::make('phone_number'),
                    ImportField::make('type')->required(),
                    ImportField::make('parent_company_id')->label('Parent Company')
                        ->mutateBeforeCreate(fn($value) => \App\Models\Company::where('company_name', $value)->first()?->id ?? $value),
                ])
        ];
    }
}
