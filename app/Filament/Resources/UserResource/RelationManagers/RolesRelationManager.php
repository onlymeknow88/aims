<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\PermissionRegistrar;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

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
                    ->recordSelectOptionsQuery(fn (Builder $query, RelationManager $livewire) => $query->whereNotIn('id', $livewire->ownerRecord->roles->pluck('id')))
//                    ->recordSelectOptionsQuery(fn (Builder $query, RelationManager $livewire) => $query->whereDoesntHave('users', function ($query) use ($livewire) {
//                        $query->where('id', $livewire->ownerRecord->id);
//                    }))
                	->preloadRecordSelect()
                ->after(function () {
                    app()[PermissionRegistrar::class]->forgetCachedPermissions();
                })
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
