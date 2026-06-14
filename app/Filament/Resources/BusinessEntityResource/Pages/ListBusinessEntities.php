<?php

namespace App\Filament\Resources\BusinessEntityResource\Pages;

use App\Filament\Resources\BusinessEntityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBusinessEntities extends ListRecords
{
    protected static string $resource = BusinessEntityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
