<?php

namespace App\Filament\Resources\BusinessEntityResource\Pages;

use App\Filament\Resources\BusinessEntityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessEntity extends EditRecord
{
    protected static string $resource = BusinessEntityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
