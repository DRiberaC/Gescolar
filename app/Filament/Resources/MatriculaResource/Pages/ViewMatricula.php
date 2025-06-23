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
                ->url(fn() => route('reporte.pdf.matricula', ['id' => $this->record->id]))
                ->openUrlInNewTab()
                ->color('primary'),
        ];
    }
}
