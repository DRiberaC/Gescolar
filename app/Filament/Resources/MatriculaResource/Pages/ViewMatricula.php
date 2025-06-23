<?php

namespace App\Filament\Resources\MatriculaResource\Pages;

use App\Filament\Resources\MatriculaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
// use Filament\Notifications\Notification;

class ViewMatricula extends ViewRecord
{
    protected static string $resource = MatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('generar_pdf')
                ->label('Generar PDF')
                ->icon('heroicon-o-document-text')
                ->action('generarPdf') // Método que defines abajo
                ->color('primary'),
        ];
    }

    public function generarPdf()
    {
        // $this->notify('success', 'El botón funciona. ¡Aquí generaremos el PDF!');
        \Filament\Notifications\Notification::make()
            ->title('El botón funciona')
            ->body('¡Aquí generaremos el PDF!')
            ->success()
            ->send();
    }
}
