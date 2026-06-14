<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\PermissionRegistrar;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelect(function (Forms\Components\Select $select) {
                        return $select->multiple();
                    })
                    ->preloadRecordSelect()
                    ->after(function () {
                        app()[PermissionRegistrar::class]->forgetCachedPermissions();
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->after(function () {
                        app()[PermissionRegistrar::class]->forgetCachedPermissions();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make()
                    ->after(function () {
                        app()[PermissionRegistrar::class]->forgetCachedPermissions();
                    }),
            ]);
    }
}
