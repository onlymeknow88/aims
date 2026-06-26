<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\EmployeeStatus;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\Rule;

class CreateUser extends CreateRecord
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
            // ->rules([
            //     function () {
            //         return function ($attribute, $value, $fail) {
            //             if (User::where('email', $value)->exists()) {
            //                 $fail('The :attribute has already been taken.');
            //             }
            //         };
            //     },
            // ]),
            Forms\Components\Select::make('departments')
                ->label('Departments')
                ->multiple()
                ->relationship('departments', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - " . ($record->company->document_code ?? $record->company->company_name ?? ''))
                ->required(),
            Forms\Components\TextInput::make('password')
                ->required()
                ->password()
                ->dehydrateStateUsing(fn($state) => \Hash::make($state)),
            Forms\Components\Toggle::make('create_employee')
                ->label('Create Employee Data')
                ->reactive()
                ->dehydrated(false),
            Forms\Components\Section::make('Employee Data')
                ->when(fn(callable $get) => $get('create_employee'))
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
}
