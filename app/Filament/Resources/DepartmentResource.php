<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\Department;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('ID')
                    ->visibleOn('edit')
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->searchable()
                    ->relationship('company', 'company_name'),
                Forms\Components\TextInput::make('document_code')
                    ->label('Code')
                    ->nullable()
                    ->string()
                    ->maxLength(10),
                Forms\Components\TextInput::make('name')
                    ->label('Departments')
                    ->required()
                    ->string()
                    ->maxLength(100),
                Forms\Components\Select::make('head_id')
                    ->label('Head')
                    ->searchable()
                    ->relationship('head', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_code')
                    ->label('Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('head.name')
                    ->default('—'),
            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CodeRelationManager::class,
            RelationManagers\SectionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
