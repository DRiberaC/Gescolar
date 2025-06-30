<?php

namespace App\Filament\Resources\CalificacionResource\Pages;

use App\Filament\Resources\CalificacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCalificacion extends ViewRecord
{
    protected static string $resource = CalificacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
