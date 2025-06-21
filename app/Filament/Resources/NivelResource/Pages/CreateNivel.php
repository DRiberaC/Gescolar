<?php

namespace App\Filament\Resources\NivelResource\Pages;

use App\Filament\Resources\NivelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNivel extends CreateRecord
{
    protected static string $resource = NivelResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
