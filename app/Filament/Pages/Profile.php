<?php

namespace App\Filament\Pages;

use App\Models\Admin;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Profile extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile';

    protected static bool $shouldRegisterNavigation = false;

    public Admin $admin;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->admin = \Auth::user();

        $this->form->fill([
            'name' => $this->admin->name,
            'email' => $this->admin->email,
        ]);
    }

    /**
     * @return Admin
     */
    protected function getFormModel(): Admin
    {
        return $this->admin;
    }

    /**
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Fieldset::make('Personal Information')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->required()->email(),
                ]),

            Fieldset::make('Change Password')
                ->schema([
                    TextInput::make('current_password')
                        ->nullable()
                        ->password()
                        ->currentPassword()
                        ->columnSpanFull(),
                    TextInput::make('password')
                        ->nullable()
                        ->password()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->nullable()
                        ->password()
                ])
        ];
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        $data = $this->form->getState();

        $this->admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if(!is_null($data['current_password']) && !is_null($data['password'])){
            $this->admin->update([
                'password' => \Hash::make($data['password'])
            ]);
        }

        Notification::make()
            ->title('Profile Updated')
            ->success()
            ->send();
    }
}
