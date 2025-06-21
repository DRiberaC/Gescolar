<?php

namespace App\Filament\Resources\GestionResource\Pages;

use App\Filament\Resources\GestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGestion extends CreateRecord
{
    protected static string $resource = GestionResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
