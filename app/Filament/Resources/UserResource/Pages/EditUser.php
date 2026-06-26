<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\EmployeeStatus;
use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->string()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('departments')
                ->label('Departments')
                ->multiple()
                ->relationship('departments', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - " . ($record->company->document_code ?? $record->company->company_name ?? ''))
                ->required(),
            Forms\Components\TextInput::make('password')
                ->nullable()
                ->password()
                ->dehydrateStateUsing(fn($state) => filled($state) ? \Hash::make($state) : null)
                ->dehydrated(fn($state) => filled($state)),
            Forms\Components\Toggle::make('google2fa_enabled')
                ->label('Otentikasi 2FA Aktif')
                ->helperText('Matikan toggle ini untuk menonaktifkan/reset 2FA pengguna.'),
            Forms\Components\Toggle::make('create_employee')
                ->label('Create Employee Data')
                ->reactive()
                ->dehydrated(false)
                ->when(fn() => empty($this->record->employee)),
            Forms\Components\Section::make('Employee Data')
                ->when(fn(callable $get) => !empty($this->record->employee) || $get('create_employee'))
                ->relationship('employee')
                ->schema([
                    Forms\Components\TextInput::make('number')
                        ->label('Employee Number')
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('id_number')
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_birth'),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'male' => 'Male',
                            'female' => 'Female'
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('blood_type'),
                    Forms\Components\TextInput::make('marital_status'),
                    Forms\Components\Select::make('employee_status')
                        ->label('Status')
                        ->required()
                        ->options(EmployeeStatus::asSelectArray())
                ]),
        ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['google2fa_enabled']) && !$data['google2fa_enabled']) {
            $data['google2fa_secret'] = null;
        }
        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
