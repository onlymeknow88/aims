<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CodeRelationManager extends RelationManager
{
    protected static string $relationship = 'codes';

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $label = 'Business Codes';

    protected function getTableHeading(): string | \Illuminate\Contracts\Support\Htmlable | \Closure | null
    {
        return new \Illuminate\Support\HtmlString('
            <div class="flex items-center gap-x-2">
                <span>Codes</span>
                <span 
                    x-data
                    x-tooltip.raw="Code digunakan untuk modul Document System. Jika dikosongkan, Department tidak akan muncul di Document System."
                    onclick="alert(\'Code digunakan untuk modul Document System. Jika dikosongkan, Department tidak akan muncul di Document System.\')"
                    class="cursor-pointer"
                >
                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
        ');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->helperText('Code digunakan untuk modul Document System. Jika dikosongkan, Department tidak akan muncul di Document System.')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
