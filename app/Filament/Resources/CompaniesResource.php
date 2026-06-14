<?php

namespace App\Filament\Resources;

use App\Enums\CompanyType;
use App\Filament\Resources\CompaniesResource\Pages;
//use App\Filament\Resources\CompaniesResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompaniesResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

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
                Forms\Components\Select::make('user_id')
                    ->label('KTT / PJO')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->string(),
                Forms\Components\TextInput::make('document_code')
                    ->nullable()
                    ->string(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->string(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->string(),
                Forms\Components\Select::make('type')
                    ->options(CompanyType::asSelectArray())
                    ->required()
                    ->string(),
                Forms\Components\Select::make('parent_company_id')
                    ->label('Parent')
                    ->searchable()
                    ->relationship('parent', 'company_name')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('KTT / PJO'),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_code'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('parent.company_name')
                    ->searchable()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompanies::route('/create'),
            'edit' => Pages\EditCompanies::route('/{record}/edit'),
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
