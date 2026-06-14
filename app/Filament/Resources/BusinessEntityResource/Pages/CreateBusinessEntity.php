<?php

namespace App\Filament\Resources\BusinessEntityResource\Pages;

use App\Filament\Resources\BusinessEntityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBusinessEntity extends CreateRecord
{
    protected static string $resource = BusinessEntityResource::class;
}
