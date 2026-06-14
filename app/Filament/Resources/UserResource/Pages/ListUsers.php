<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Imports\UsersImport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Download Template')
                ->action(function () {
                    return Excel::download(new \App\Exports\UsersTemplateExport(), 'users_import_template.xlsx');
                })
                ->color('success')
                ->icon('heroicon-o-download'),
            Actions\Action::make('Import Users')
                ->form([
                    FileUpload::make('file')
                        ->label('File (xls, xlsx, csv)')
                        ->disk('local') // Pastikan file di-upload ke storage/app
                        ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $filePath = $data['file'];
                    if (is_array($filePath)) {
                        $filePath = $filePath[0] ?? null;
                    }
                    if (!$filePath) {
                        Notification::make()
                            ->title('No file uploaded')
                            ->danger()
                            ->send();
                        return;
                    }
                    $absolutePath = \Storage::disk('local')->path($filePath);
                    if (!file_exists($absolutePath)) {
                        Notification::make()
                            ->title('File not found: ' . $absolutePath)
                            ->danger()
                            ->send();
                        return;
                    }
                    try {
                        \Maatwebsite\Excel\Facades\Excel::import(new class extends \App\Imports\UsersImport {
                            public static $importErrors = [];
                            public function model(array $row)
                            {
                                try {
                                    return parent::model($row);
                                } catch (\Throwable $e) {
                                    self::$importErrors[] = $e->getMessage();
                                    return null;
                                }
                            }
                        }, $absolutePath);
                        if (!empty(\App\Imports\UsersImport::$importErrors)) {
                            Notification::make()
                                ->title('Import Error')
                                ->body(implode("\n", \App\Imports\UsersImport::$importErrors))
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Import Success')
                                ->success()
                                ->send();
                        }
                    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                        $failures = $e->failures();
                        $messages = collect($failures)->map(function($failure) {
                            return 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
                        })->implode("\n");
                        Notification::make()
                            ->title('Import Error')
                            ->body($messages)
                            ->danger()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import Error')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
